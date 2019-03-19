<?php

namespace backend\controllers;

use Yii;
use backend\models\Blogroll;
use backend\models\BlogrollSearch;
use yii\base\ErrorException;
use yii\debug\models\search\Base;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\BaseModel;

/**
 * BlogrollController implements the CRUD actions for Blogroll model.
 */
class BlogrollController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view', 'index', 'create', 'update', 'delete', 'check'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Blogroll models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('友情链接管理')){
            return $this->redirect(['site/login']);
        }

        $searchModel = new BlogrollSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Blogroll model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (!Yii::$app->user->can('查看友情链接')){
            return $this->redirect(['site/login']);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Blogroll model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * throw Exception
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('添加友情链接')){
            return $this->redirect(['site/login']);
        }

        $model = new Blogroll();

        if ($model->load(Yii::$app->request->post())) {
            $model->apply_time = time();
            if($model->is_checked == Blogroll::CHECKEDPASSED){
                $model->pass_time = time();
            }

            if($model->save()){
                if(!empty($model->email)){
                    BaseModel::sendMail(\Yii::$app->params['supportEmail'], \Yii::$app->params['adminEmail'], $model->web_name.'发来了友链申请！');
                    \backend\models\ManagerLog::saveLog(Yii::$app->user->id, "友情链接", \backend\models\ManagerLog::CREATE, $model->web_name);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                throw new \Exception(current($model->getErrors())[0]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Blogroll model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('编辑友情链接')){
            return $this->redirect(['site/login']);
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \backend\models\ManagerLog::saveLog(Yii::$app->user->id, "友情链接", \backend\models\ManagerLog::UPDATE, $model->web_name);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Blogroll model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('删除友情链接')){
            return $this->redirect(['site/login']);
        }

        $this->findModel($id)->delete();
        \backend\models\ManagerLog::saveLog(Yii::$app->user->id, "友情链接", \backend\models\ManagerLog::DELETE, $model->web_name);
        return $this->redirect(['index']);
    }

    /**
     * checked a blogroll
     * if checked is successful,the browser will be redirected to the 'index' page.
     * @param integer $id
     * $return mixed
     **/
    public function actionCheck($id){
        if (!Yii::$app->user->can('审核友情链接')){
            return $this->redirect(['site/login']);
        }

        if (($model = Blogroll::findOne($id)) !== null) {

            if($model->is_checked == Blogroll::CHECKEDPASSED){
                return $this->redirect(['view', 'id' => $model->id]);
            }

            $model->is_checked = Blogroll::CHECKEDPASSED;
            $model->pass_time = time();

            if($model->save()){
                if(!empty($model->email)){
                    BaseModel::sendMail(\Yii::$app->params['supportEmail'], $model->email, '您的友情链接申请已通过！');
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                throw new \Exception(current($model->getErrors())[0]);
            }
        } else {
            throw new NotFoundHttpException('The blog roll does not exist.');
        }
    }

    /**
     * Finds the Blogroll model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blogroll the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blogroll::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
