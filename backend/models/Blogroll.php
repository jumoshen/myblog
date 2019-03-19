<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "blogroll".
 *
 * @property integer $id
 * @property string $web_name
 * @property string $link
 * @property string $web_logo_link
 * @property string $qq
 * @property string $email
 * @property string $remark
 * @property integer $is_checked
 * @property string $apply_time
 * @property string $pass_time
 */
class Blogroll extends \yii\db\ActiveRecord
{
    /**
     * 审核通过
     **/
    const CHECKEDPASSED = 1;

    /**
     * 审核未通过
     **/
    const UNCHECKEDPASSED = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'blogroll';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['web_name', 'link', 'qq', 'is_checked', 'email'], 'required'],
            [['is_checked'], 'integer'],
            [['web_name'], 'string', 'max' => 20],
            [['link', 'email', 'remark'], 'string', 'max' => 50],
            [['web_logo_link'], 'string', 'max' => 255],
            [['qq'], 'string', 'max' => 13],
            [['apply_time', 'pass_time'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'web_name' => '网站名称',
            'link' => '网站链接',
            'web_logo_link' => '网站logo链接',
            'qq' => 'QQ',
            'email' => 'Email',
            'remark' => '备注',
            'is_checked' => '是否审核',
            'apply_time' => '申请时间',
            'pass_time' => '通过时间',
        ];
    }

    /**
     * get blog roll status array
     * @return array
     **/
    public static function statusArray(){
        return array(
            ''                    => '请选择',
            self::UNCHECKEDPASSED => '未通过',
            self::CHECKEDPASSED   => '已通过',
        );
    }

    /**
     * get all blog rolls
     * @return array
     **/
    public static function getBlogrolls(){
        return self::find()->where(['is_checked' => self::CHECKEDPASSED])->asArray()->all();
    }


}
