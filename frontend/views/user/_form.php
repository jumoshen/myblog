<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\User;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'nickname')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'realname')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'sex')->dropDownList(User::sexArray()) ?>

    <?= $form->field($model, 'province')->textInput(['maxlength' => 32]) ?>

    <?= $form->field($model, 'mobile')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'head_avatar')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => [
                'initialPreview'=>[
                    $model->head_avatar
                ],
                'initialPreviewAsData'=>true,
            ],
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('修改', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
