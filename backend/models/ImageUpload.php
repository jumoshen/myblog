<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;

class ImageUpload extends \yii\db\ActiveRecord
{

    /**
     * @param $model
     * @param $field
     * @param $path
     * @param bool $frontendNeed
     */
    public static function imageUploads($model, $field, $path, $frontendNeed = false)
    {
        $num = date('Ymd_His', time()) . mt_rand(1000, 9999);

        $model->$field = UploadedFile::getInstance($model, $field);

        $savePath = $path . date('Y_m_d', time());

        if ($frontendNeed) {
            $savePath = '../../frontend/web/' . $savePath;
        }

        if (!file_exists($savePath)) {
            mkdir($savePath);
        }

        $model->$field->saveAs($savePath . '/' . $num . '.' . $model->$field->extension);
        $model->$field = $path . date('Y_m_d', time()) . '/' . $num . '.' . $model->$field->extension;
    }
}
