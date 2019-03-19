<?php

namespace backend\controllers;

use backend\services\StudyCourseService;
use Yii;
use backend\models\StudyCourse;
use backend\models\StudyCourseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\Tag;
use backend\models\CourseTagRelation;
use backend\models\ImageUpload;

/**
 * StudyCourseController implements the CRUD actions for StudyCourse model.
 */
class StudyCourseController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view', 'index', 'create', 'update', 'delete', 'get-group'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all StudyCourse models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('教程管理')){
            return $this->redirect(['site/login']);
        }

        $searchModel = new StudyCourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudyCourse model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {

        if (!Yii::$app->user->can('查看教程')){
            return $this->redirect(['site/login']);
        }
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new StudyCourse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if (!Yii::$app->user->can('添加教程')){
            return $this->redirect(['site/login']);
        }

        $model = new StudyCourse();

        $model->created_at = time();

        if ($model->load(Yii::$app->request->post())) {
            $courseId = StudyCourseService::createCourse($model, Yii::$app->request->post());
            $this->redirect(['view', 'id' => $courseId]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing StudyCourse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        if (!Yii::$app->user->can('编辑教程')){
            return $this->redirect(['site/login']);
        }

        $model = $this->findModel($id);
        //查询标签
        $model->tags = StudyCourse::findTags($id);

	$course_cover = $model->course_cover;

        if ($model->load(Yii::$app->request->post())) {
            $model->tags = Yii::$app->request->post()['StudyCourse']['tags'];
            $transaction = Yii::$app->db->beginTransaction();
            try {
		if($_FILES['StudyCourse']['name']['course_cover']){
                    ImageUpload::imageUploads($model, 'course_cover', 'uploads/course_cover/');
                }else{
                    $model->course_cover = $course_cover;
                }

                $model->save();
                $model->addTags($model->course_id);
                \backend\models\ManagerLog::saveLog(Yii::$app->user->id, "教程", \backend\models\ManagerLog::UPDATE, $model->course_title);
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->course_id]);
            }catch (\Exception $e) {
                $transaction->rollBack();
                throw new \Exception($e->getMessage());
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StudyCourse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('删除教程')){
            return $this->redirect(['site/login']);
        }

        $model = $this->findModel($id);

        if($model->delete()){
            \backend\models\ManagerLog::saveLog(Yii::$app->user->id, "教程", \backend\models\ManagerLog::DELETE, $model->course_title);
            return $this->redirect(['index']);
        }


    }

    /**
     * Finds the StudyCourse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return StudyCourse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudyCourse::findOne($id)) !== null) {
            $tagsArray = array();
            $tagsArray = StudyCourse::findTags($id);
            foreach($tagsArray as $tag){
                $model->tags .= $tag.',';
            }
            $model->tags = rtrim($model->tags, ',');
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
