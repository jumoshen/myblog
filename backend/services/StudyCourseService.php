<?php
/**
 * Created by PhpStorm.
 * User: lianghui
 * Date: 2018/2/23
 * Time: 16:39
 */

namespace backend\services;

use Yii;
use backend\models\StudyCourse;
use backend\models\ImageUpload;

class StudyCourseService
{
    /**
     * @desc 添加course
     * @param StudyCourse $model
     * @param $param
     * @return string
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public static function createCourse(StudyCourse $model, $param)
    {
        $model->tags = $param['StudyCourse']['tags'];

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($_FILES['StudyCourse']['name']['course_cover']) {
                ImageUpload::imageUploads($model, 'course_cover', 'uploads/course_cover/');
            } else {
                $model->course_cover = $model->defaultCover;
            }

            $model->save();
            $model->addTags($model->course_id);
            \backend\models\ManagerLog::saveLog(Yii::$app->user->id, "教程", \backend\models\ManagerLog::CREATE, $model->course_title);
            $transaction->commit();
            return $model->course_id;

        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
