<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    public $repassword;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
           // ['username', 'string', 'min' => 6, 'max' => 16],
            ['username', 'match','pattern'=>'/^[(\x{4E00}-\x{9FA5})a-zA-Z]+[(\x{4E00}-\x{9FA5})a-zA-Z_\d]*$/u','message'=>'用户名由字母，汉字，数字，下划线组成，且不能以数字和下划线开头。'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['repassword', 'required'],
            ['repassword', 'string', 'min' => 6],
            ['repassword', 'compare', 'compareAttribute' => 'password','message'=>'两次输入的密码不一致！'],

            ['verifyCode', 'captcha'],
        ];
    }


    /**
    *
    *表单转为中文
    *
    **/ 
    public function attributeLabels(){
        return[
            'username'=>'用户名',
            'password'=>'密码',
            'email'=>'邮箱',
            'repassword'=>'重复密码',
            'verifyCode'=>'验证码',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }

    private static function qqLogin($data){

        $userModel = new \common\models\User();

        $currentUser = \common\models\User::findByQqOpenid($data['qq_openid']);
        if ($currentUser) {
            return $currentUser;
        }
        $userModel->qq_openid = $data['qq_openid'];
        $userModel->username  = 'qq_user_' . $data['username'];
        $userModel->province  = $data['province'];
        $userModel->auth_key  = Yii::$app->security->generateRandomString();
        $userModel->head_avatar = self::downloadHeadAvatar($data['head_avatar']);

        if ($userModel->save()) {
            return $userModel;
        }
        return null;

    }

    /**
     * @return bool
     * @desc 执行qq登录
     */
    public static function dealQqLogin(){
        $code = \Yii::$app->request->get("code");

        if (!empty($code && (\Yii::$app->session->get('state') == \Yii::$app->request->get("state")))) {
            $QQConnect   = new QqConnect();
            $accessToken = $QQConnect->getQqAccessToken();
            $openId      = $QQConnect->getOpenid();
            $qqUserInfo  = QqConnect::httpRequest('https://graph.qq.com/user/get_user_info?access_token=' . $accessToken . '&oauth_consumer_key=101398718&openid=' . $openId);

            $qqUserInfo               = json_decode('[' . $qqUserInfo . ']', true)[0];
            $userModel                = array();
            $userModel['qq_openid']   = $openId;
            $userModel['username']    = 'qq_user_' . $qqUserInfo['nickname'];
            $userModel['province']    = $qqUserInfo['province'];
            $userModel['auth_key']    = Yii::$app->security->generateRandomString();
            $userModel['head_avatar'] = $qqUserInfo['figureurl_qq_2'];

            if ($user = self::qqLogin($userModel)) {
                if (Yii::$app->getUser()->login($user)) {
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * @param $avatar
     * @return string
     * @throws \Exception
     */
    private static function downloadHeadAvatar($avatar){
        $path     = 'uploads/user/head_avatar/';
        $num      = date('Ymd_His', time()) . mt_rand(1000, 9999);
        $savePath = $path . date('Y_m_d', time());

        if (!file_exists($savePath)) {
            mkdir($savePath);
        }
        $avatarPath = $savePath . '/' . $num . '.png';
        if (!copy($avatar, $avatarPath)){
            throw new \Exception('用户头像保存失败');
        }
        return $avatarPath;
    }
}
