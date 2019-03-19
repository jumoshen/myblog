<?php

namespace frontend\controllers;

use Yii;
use backend\models\Mynote;
use backend\models\MynoteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MynoteController implements the CRUD actions for Mynote model.
 */
class MynoteController extends Controller
{
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * Lists all Mynote models.
     * @return mixed
     */
    public function actionIndex()
    {
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

        $model = new Mynote();

        if ($model->load(Yii::$app->request->post())) {
            $model->create_at = time();
            $model->author    = $_SERVER['REMOTE_ADDR'];
            $model->update_at = time();
            if($model->save()){
                if (!\Yii::$app->user->isGuest) {
                    ##\backend\models\ManagerLog::saveLog(Yii::$app->user->id, "笔记", \backend\models\ManagerLog::CREATE, $model->title);
                }
                
                return $this->redirect(['index']);                
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
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
