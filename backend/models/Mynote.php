<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "mynote".
 *
 * @property integer $id
 * @property string $title
 * @property string $link
 * @property integer $create_at
 * @property integer $update_at
 * @property string $author
 */
class Mynote extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'myNote';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('noteDb');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'link'], 'required'],
            [['create_at', 'update_at'], 'integer'],
            ['link','match','pattern'=>'/^(http|https):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)/i','message'=>'请输入有效的网址'],
            [['title', 'link', 'author'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'link' => '链接',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'author' => 'IP',
        ];
    }

    /**
     *@return array $myNotesArray
     **/
    public static function myNotesArray(){
        $myNotes = self::find()->select(['title'])->asArray()->all();
        $myNotesArrayContent = array();
        foreach ($myNotes as $key => $value) {
            $myNotesArrayContent[$key] = $myNotes[$key]['title'];
        }
        return $myNotesArrayContent;
    }
}
