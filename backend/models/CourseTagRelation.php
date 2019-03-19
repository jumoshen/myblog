<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "course_tag_relation".
 *
 * @property string $id
 * @property string $course_id
 * @property string $tag_id
 */
class CourseTagRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_tag_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'tag_id'], 'required'],
            [['course_id', 'tag_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_id' => 'Course ID',
            'tag_id' => 'Tag ID',
        ];
    }
}
