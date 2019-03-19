<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use backend\models\ImageUpload;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view', 'index', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('用户管理')){
            return $this->redirect(['site/login']);
        }

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (!Yii::$app->user->can('查看用户')){
            return $this->redirect(['site/login']);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('编辑用户')){
            return $this->redirect(['site/login']);
        }

        $model = $this->findModel($id);

        $head_avatar = $model->head_avatar;

        if ($model->load(Yii::$app->request->post())) {

            if($_FILES['User']['name']['head_avatar']){

                ImageUpload::imageUploads($model,'head_avatar','uploads/user/head_avatar/', true);

            }else{

                $model->head_avatar = $head_avatar;       //更新时如果没有图片上传  则获取原来的图片

            }

            if ($model->save()) {
                \backend\models\ManagerLog::saveLog(Yii::$app->user->id, "用户", \backend\models\ManagerLog::UPDATE, $model->username);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
	    $model->head_avatar = Yii::$app->params['frontendUrl'].$model->head_avatar;
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('删除用户')){
            return $this->redirect(['site/login']);
        }
        $model = $this->findModel($id);

        if ($model->delete()) {
            \backend\models\ManagerLog::saveLog(Yii::$app->user->id, "用户", \backend\models\ManagerLog::DELETE, $model->username);
            return $this->redirect(['index']);
        }

        
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
