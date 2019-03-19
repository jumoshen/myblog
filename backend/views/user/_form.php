<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'realname')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'sex')->dropDownList(User::sexArray()) ?>

    <?= $form->field($model, 'province')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => 15]) ?>
    
    <?php if(!$model->isNewRecord){?>
    
    <?php if($model->head_avatar){ ?>

    <div id="coverDiv"><img id="coverImg" height="100%" width="120" src="<?=$model->getHeadAvatar();?>"/></div>

    <?php } ?>

    <?php }?>

    <div id="coverDiv"><img id="coverImg" height="100%" width="120"/></div>

    <?= $form->field($model, 'head_avatar')->fileInput() ?>

    <?php 
        $this->registerJsFile('/js/uploadPreview.min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
        $this->registerJs('new uploadPreview({ UpBtn: "user-head_avatar", DivShow: "coverDiv", ImgShow: "coverImg" });');
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
