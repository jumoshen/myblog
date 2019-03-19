<?php

namespace frontend\controllers;

use Yii;
use backend\models\StudyCourse;
use backend\models\StudyCourseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
                'except' => [
                        'view', 'index', 'create', 'update', 'delete', 'get-group'
                ],
                'rules' => [
                    // [
                    //     'actions' => ['view', 'index', 'create', 'update', 'delete', 'get-group'],
                    //     'allow' => true,
                    //     'roles' => ['@'],
                    // ],
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

        $courses = StudyCourse::getCourseList();

        return $this->redirect(['site/index']);
    }

    /**
     * Displays a single StudyCourse model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        //浏览量+1
        StudyCourse::increaseViews($id);
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
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \frontend\models\ManagerLog::saveLog(Yii::$app->user->id, "教程", \frontend\models\ManagerLog::CREATE, $model->course_title);
            return $this->redirect(['view', 'id' => $model->course_id]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \frontend\models\ManagerLog::saveLog(Yii::$app->user->id, "教程", \frontend\models\ManagerLog::UPDATE, $model->course_title);
            return $this->redirect(['view', 'id' => $model->course_id]);
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
            \frontend\models\ManagerLog::saveLog(Yii::$app->user->id, "教程", \frontend\models\ManagerLog::DELETE, $model->course_title);
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
            $model->tags = StudyCourse::findTags($id);
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
