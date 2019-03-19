<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property string $title
 * @property string $intro
 * @property string $pic
 * @property string $author
 * @property integer $create_at
 * @property integer $upload_at
 * @property integer $status
 * @property integer $is_delete
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'intro', 'pic', 'author', 'create_at', 'upload_at'], 'required'],
            [['intro'], 'string'],
            [['create_at', 'upload_at', 'status', 'is_delete'], 'integer'],
            [['title', 'pic', 'author'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'intro' => 'Intro',
            'pic' => 'Pic',
            'author' => 'Author',
            'create_at' => 'Create At',
            'upload_at' => 'Upload At',
            'status' => 'Status',
            'is_delete' => 'Is Delete',
        ];
    }
}
