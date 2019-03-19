<?php

namespace frontend\models;

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
class User extends \backend\models\User
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
            [['mobile'], 'string', 'max' => 15],

            [['username', 'nickname', 'realname'], 'match','pattern'=>'/^[(\x{4E00}-\x{9FA5})a-zA-Z]+[(\x{4E00}-\x{9FA5})a-zA-Z_\d]*$/u','message'=>'用户名由字母，汉字，数字，下划线组成，且不能以数字和下划线开头。'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
           ## ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.', 'on' => ['create']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => '邮箱',
            'role' => 'Role',
            'status' => '状态',
            'created_at' => '注册时间',
            'updated_at' => '更新时间',
            'nickname' => '昵称',
            'realname' => '真实姓名',
            'sex' => '性别',
            'province' => '省份',
            'mobile' => '手机号码',
            'head_avatar' => '头像',
        ];
    }

     /**
     * @param $email
     * @return array
     * @desc 绑定邮箱
     */
    public static function bindEmail($email){
        if (\Yii::$app->user->isGuest) {
            return [
                'code'    => 400,
                'message' => '请先登录'
            ];
        }

        if (!preg_match('/^[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/', $email)) {
            return [
                'code'    => 403,
                'message' => '邮箱格式错误'
            ];
        }

        $userId = Yii::$app->user->identity->getId();

	$user = User::find()->where(['email' => $email]);
        $user = $user->andWhere(['!=', 'id', $userId])->asArray()->one();

        if ($user) {
            return [
                'code'    => 405,
                'message' => '此邮箱已被绑定'
            ];
        }

        $user   = User::findOne(['id' => $userId]);

        if (!$user || $user['email']) {
            return [
                'code'    => 401,
                'message' => '未知错误'
            ];
        }

        $user->email = $email;

        if (!$user->save(false)) {
	    //return $user->getErrors();
            return [
                'code'    => 402,
                'message' => '保存失败'
            ];
        }

        return [
            'code'    => 200,
            'message' => '绑定成功'
        ];
    }
}
