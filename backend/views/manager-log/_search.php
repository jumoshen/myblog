<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ManagerLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="manager-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="form-group  form-inline">

    <?= $form->field($model, 'realname') ?>

    <?= $form->field($model, 'module_name') ?>

    <?= $form->field($model, 'createdFrom')->widget(\kartik\date\DatePicker::className(), [
        //'language' => 'ru',
        'pluginOptions' => ['dateFormat' => 'yyyy-MM-dd',]
    ]) ?>
    <?= $form->field($model, 'createdTo')->widget(\kartik\date\DatePicker::classname(), [
        //'language' => 'ru',
        'pluginOptions' => ['dateFormat' => 'yyyy-MM-dd',]

    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
    </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
