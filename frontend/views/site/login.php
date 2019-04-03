<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php 
    $this->registerCssFile('/css/jquery-ui-1.10.4.min.css',['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerCssFile('/css/sliderlock.css',['depends' => [\yii\web\JqueryAsset::className()]]);

    $this->registerJsFile('/js/jquery-ui-1.10.4.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
 //   $this->registerJsFile('/js/sliderlock.js',['depends' => [\yii\web\JqueryAsset::className()]]);
 ?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请填写以下信息:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

   <!--             <div class="form-group field-loginform-password required">
                <label class="control-label" for="loginform-password">滑动解锁</label>
                <div id="slider" class="sliderLock">
                    <p>Slide to Unlock</p>
                </div>

                </div> -->


                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <div style="color:#999;margin:1em 0">
                    忘记密码 <?= Html::a('请点击', ['site/request-password-reset']) ?>.
                </div>

                <div class="form-group">
                    <?= Html::submitButton('登录', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
	    <div class="panel-body">
                 <a href="<?= Url::to(['user/qq-login'])?>" target="__block"><img src="./images/qq_login.png" width="32" alt="使用腾讯QQ账号登录" title="腾讯QQ账号登录"></a>
            </div>
        </div>
    </div>
</div>
