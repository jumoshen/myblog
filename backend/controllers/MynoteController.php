<?php

namespace backend\controllers;

use Yii;
use backend\models\Mynote;
use backend\models\MynoteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MynoteController implements the CRUD actions for Mynote model.
 */
class MynoteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Mynote models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('笔记管理')){
            return $this->redirect(['site/login']);
        }

        $searchModel = new MynoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Mynote model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('添加笔记')){
            return $this->redirect(['site/login']);
        }

        $model = new Mynote();

        if ($model->load(Yii::$app->request->post())) {
            $model->create_at = time();
            $model->author    = $_SERVER['REMOTE_ADDR'];
            $model->update_at = time();
	    
            if($model->save()){
                \backend\models\ManagerLog::saveLog(Yii::$app->user->id, "笔记", \backend\models\ManagerLog::CREATE, $model->title);
                return $this->redirect(['index']);                
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Mynote model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (!Yii::$app->user->can('编辑笔记')){
            return $this->redirect(['site/login']);
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->update_at = time();
            if ($model->save()) {
                \backend\models\ManagerLog::saveLog(Yii::$app->user->id, "笔记", \backend\models\ManagerLog::UPDATE, $model->title);
                return $this->redirect(['index']);
            }
            
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Mynote model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->can('删除笔记')){
            return $this->redirect(['site/login']);
        }

        $model = $this->findModel($id);
        if ($model->delete()) {
            \backend\models\ManagerLog::saveLog(Yii::$app->user->id, "笔记", \backend\models\ManagerLog::DELETE, $model->title);
            return $this->redirect(['index']);
        }

        
    }

    /**
     * Finds the Mynote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mynote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mynote::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
