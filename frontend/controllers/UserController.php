<?php

namespace frontend\controllers;

use Yii;
use frontend\models\User;
use frontend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use frontend\models\QqConnect;
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
                'except' => [
                    'qq-login', 'test', 'my-chat-room'
                ],
                'rules' => [

                    [
                        'actions' => ['view', 'update', 'bind-email'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],


                ],
            ],
        ];
    }


    /**
     * Displays a single User model.
     * @return mixed
     */
    public function actionView()
    {
        $id = Yii::$app->user->id;

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        $id = Yii::$app->user->id;

        $model = $this->findModel($id);

	$head_avatar = $model->head_avatar;
	
        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = time();
	    if($_FILES['User']['name']['head_avatar']){

                ImageUpload::imageUploads($model,'head_avatar','uploads/user/head_avatar/');

            }else{
		$model->head_avatar = $head_avatar;
	    }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);               
            }else{
		Yii::$app->session->setFlash('error', $model->getFirstErrors());
		return $this->redirect(['update']);
	    }
        } else {
	    $model->head_avatar = Yii::$app->params['frontendUrl'].$model->head_avatar;
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    /**
    * myChatRoom
    **/
    public function actionMyChatRoom(){
	$this->layout = false;
        $socket = Yii::$app->params['socket'];

        return $this->render('my-chat-room', [
            'socket' => $socket,
        ]);
    }

    public function actionQqLogin(){
        QqConnect::getCode(QqConnect::REDIRECT_URL);
    }

    /**
     * @return array
     * @desc bind your email
     */
    public function actionBindEmail(){
        if(Yii::$app->request->isAjax){
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $result = \frontend\models\User::bindEmail(Yii::$app->request->post('email'));
            return $result;
        }
    }
    
    public function actionTest(){
        $socket = Yii::$app->params['socket'];

        return $this->render('test', [
            'socket' => $socket,
        ]);
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
