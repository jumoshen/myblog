<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $nickname
 * @property string $realname
 * @property integer $sex
 * @property string $province
 * @property string $mobile
 * @property string $head_avatar
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role', 'status', 'created_at', 'updated_at', 'sex'], 'integer'],
            [['created_at'], 'required'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'head_avatar'], 'string', 'max' => 255],
            [['auth_key', 'province'], 'string', 'max' => 32],
            [['nickname'], 'string', 'max' => 50],
            [['realname'], 'string', 'max' => 20],
            [['mobile'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '姓名',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'role' => '角色',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'nickname' => '昵称',
            'realname' => '真实姓名',
            'sex' => '性别',
            'province' => '省份',
            'mobile' => '手机号',
            'head_avatar' => '头像',
        ];
    }


    /**
    * getHeadAvatar
    **/
    public function getHeadAvatar(){
	if(strstr($this->head_avatar, 'http')) return $this->head_avatar;
        return Yii::$app->params['frontendUrl'].$this->head_avatar;
    }

    public static function sexArray(){
        $sexArray = array(
            ''  => '请选择',
            '0' => '保密',
            '1' => '男',
            '2' => '女',
        );
        return $sexArray;
    }


    public function getSex(){
        $sexArray = self::sexArray();
        return $sexArray[$this->sex];
    }


    /**
     * get user by id
    **/
    public static function findByUserId($userID)
    {
        return static::findOne(['id' => $userID]);
    }
}
