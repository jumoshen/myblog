<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Manager */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="manager-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role')->dropDownList(\backend\models\AuthItem::getRoleArray($model)) ?>
    <?php if($model->getScenario() != "create"):?>
        <?= $form->field($model, 'username')->textInput(['readonly'=>true]) ?>
    <?php else:?>
        <?= $form->field($model, 'username')->textInput() ?>
    <?php endif;?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    
    <?= $form->field($model, 'repassword')->passwordInput() ?>
    
    <?= $form->field($model, 'branch')->dropDownList(\backend\models\Organization::getBranchArray()) ?>
    
    <?= $form->field($model, 'realname')->textInput() ?>
    
    <?= $form->field($model, 'mobile')->textInput() ?>
    
    <?= $form->field($model, 'email')->textInput() ?>
    
    <?= $form->field($model, 'status')->dropDownList($model->getStatusArray()) ?>
    

    <div class="form-group">
        <?= Html::submitButton('确定', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
