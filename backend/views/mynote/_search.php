<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MynoteSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mynote-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="form-inline form-group">

        <?= $form->field($model, 'title') ?>

        <?= $form->field($model, 'link') ?>

        <?= $form->field($model, 'create_at')->widget(\kartik\date\DatePicker::classname(), [
            //'language' => 'ru',
            'pluginOptions' => ['dateFormat' => 'yyyy-MM-dd', 'class' => 'form-control']
        ]) ?>

        <?php // echo $form->field($model, 'author') ?>

        <div class="form-group">
            <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
