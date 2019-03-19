<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use backend\models\LoginForm;
use yii\filters\VerbFilter;
use backend\models\ChangePasswordForm;
use backend\models\Manager;
use backend\models\StudyCourse;
use backend\models\Region;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','request-password-reset', 'reset-password', 'captcha', 'webupload', 'get-regions', 'linkage'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'change-password', 'test'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
              'class' => 'yii\captcha\CaptchaAction',
              'maxLength' => 5,
              'minLength' => 5
            ],            
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        $message = "";
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', '请检查你的邮箱以进行下一步操作.');
                $message = '请检查你的邮箱以进行下一步操作.';

                //return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', '对不起，邮箱不存在.');
                $message = '请检查你的邮箱以进行下一步操作.';
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
            'message' => $message,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', '密码更新成功.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
    
    /**
     * 管理员修改密码
     * @throws BadRequestHttpException
     */
    public function actionChangePassword()
    {
        if (!Yii::$app->user->can('修改密码')){
            return $this->redirect(['site/login']);
        }         
        try {
            $model = new ChangePasswordForm();
            $message = "";
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
            $manager = Manager::findIdentity(Yii::$app->user->id);

            if($manager->validatePassword($model->currentPassword)){
                $manager->setPassword($model->password);
                $manager->save();
                Yii::$app->user->logout();
                return $this->goHome();
            }  else {
                $message = '密码更新失败.';
            }

        }

        return $this->render('changePassword', [
            'model' => $model,
            'message' => $message,
        ]);
    }    
    
    public function actionTest(){
        Yii::$app->session->setFlash('success', 'test Success!');
        $model = new StudyCourse();
        $content = "
## ``mysql--存数过程``
- [x] -1.查看现有的存数过程
- show procedure status;
- [x] -2.删除存储过程
- drop procedure;
- [x] -3.调用存储过程
- call procedure_name();
- [x] -4.查看单个创建语句
- show create procedure procedure_name;
```";
	   return $this->render('test', [
                'model' => $model,
                'content' => $content,
            ]);
    }

    public function actionGetRegions(){
        $regionID = Yii::$app->request->get("id");
        $regionArray = Region::getChild($regionID);
        $optionsString = "";
        foreach($regionArray as $key=>$value){
            $optionsString .= "<option value='$key'>$value</option>";
        }
        echo $optionsString;
    }

    public function actionLinkage(){
        $model = new StudyCourse();
        return $this->render('linkage', [
            'model' => $model
        ]);
    }

}
