<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/16
 * Time: 10:27
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\StudyCourse;
use yii\web\NotFoundHttpException;

/**
 * ToolController implements the CRUD actions for User model.
 */
class ToolController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionSliceFileUpload(){
        return $this->render('slice-file-upload');
    }

    public function actionUpload(){
        $fileName = Yii::$app->request->post('name');
        $index    = Yii::$app->request->post('index');

        $target   = "./slice-file/" .iconv("utf-8","gbk", $fileName) . '-' . $index;
        move_uploaded_file($_FILES['file']['tmp_name'], $target);
        usleep(200);
    }

    public function actionMergeFiles(){
        $fileName = Yii::$app->request->post('name');
        $total = Yii::$app->request->post('index');

        $target = "./slice-file/" . iconv("utf-8", "gbk", $fileName);
        $dst = fopen($target, 'wb');

        for($i = 0; $i < $total; $i++) {
            $slice = $target . '-' . $i;
            $src   = fopen($slice, 'rb');
            stream_copy_to_stream($src, $dst);
            fclose($src);
            unlink($slice);
        }
        fclose($dst);
    }

    public function actionWebTimeAxis(){
        $timeAxis = StudyCourse::find()->select(['course_title', 'created_at'])->orderBy('created_at DESC')->asArray()->all();

        $newArray = [];
        foreach($timeAxis as $key => $time){
            $currentYear = date('Y', $time['created_at']);
            $newArray[$currentYear][] = $time;
        }

        return $this->render('web-time-axis', [
           'timeArray' => $newArray
        ]);
    }
}
