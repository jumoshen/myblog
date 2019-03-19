<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Blogroll;

/* @var $this yii\web\View */
/* @var $model backend\models\BlogRoll */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-roll-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'web_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'web_logo_link')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qq')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remark')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_checked')->dropDownList(Blogroll::statusArray()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
