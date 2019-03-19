<?php
namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Manager model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Manager extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 10;
    
    public $password;
    public $repassword;    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%manager}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'mobile', 'realname', 'role'], 'required'],
            [['password', 'repassword'], 'required', 'on'=>'create'],            
            ['password', 'string', 'min' => 6],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['repassword', 'compare','compareAttribute'=>'password','message'=>'密码与确认密码必须一致'],
            ['mobile', 'mobileCheck'],
            ['email', 'email'],
            ['username','unique'],
            ['branch', 'integer'],
        ];
    }

    /**
     * 手机号检查
     * @param type $attribute
     * @param type $params
     */
    public function mobileCheck($attribute, $params){
            if(!preg_match('/^(1)\d{10}$/',$this->mobile)) {
                $this->addError($attribute, '请输入正确的手机号');
            }     
    }    
    
     /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'email' => '邮件地址',
            'role' => '角色',
            'status' => '状态',
            'mobile' => '手机号',
            'branch' => '分支',
            'realname' => '姓名',
            'password'=>'密码',
            'repassword'=>'确认密码',            
        ];
    }    
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['manager.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    /**
     * 获取状态
     * @return string 状态
     */
    public function getStatus(){
        $statusArray = $this->getStatusArray();
        return $statusArray[$this->status];
    }
    
    /**
     * 获取商品状态数组
     * @return array 商品状态数组
     */
    public function getStatusArray(){
        return array(
            ''=>'请选择',
            '10'=>'正常',
            '0'=>'禁止',
        );
    }     
    
    /**
     * 获取状态
     * @return string 状态
     */
    public function getBranch(){
        $statusArray = \backend\models\Organization::getBranchArray();
        return $statusArray[$this->branch];
    }    
    
    /**
     * 重设权限
     */
    public function resetAuth(){
            $auth = Yii::$app->authManager;
            $auth->revokeAll($this->id);
            $admin = $auth->getRole($this->role);
            $auth->assign($admin, $this->id); 
    }
    
    /**
     * 获取指定角色的用户数
     * @param string $roleName
     * @return int 指定角色的用户数
     */
    public static function getUsers($roleName){
        return self::find()->where(['role'=>$roleName])->count();
    }
    
    /**
     * 获取机构ID
     * @return int 机构ID
     */
    public static function getManagerBranchID(){
        $manager = self::findOne(Yii::$app->user->id);
        return $manager->branch;
    }
}
