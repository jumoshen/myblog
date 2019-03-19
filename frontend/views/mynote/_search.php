<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Mynote;

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

    <?= $form->field($model, 'title')->widget('yii\jui\AutoComplete',[

        'options'=>['class'=>'form-control','placeholder'=>'请输入标题'],

        'clientOptions'=>[
            'source'=> Mynote::myNotesArray()
        ]
    ]) ?>

    <?= $form->field($model, 'link') ?>

    <?= $form->field($model, 'create_at')->widget(\yii\jui\DatePicker::classname(), [
        //'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
            'class' => 'form-control'
        ],
    ]) ?>

    <?php // echo $form->field($model, 'author') ?>

    <div class="form-group">
        <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
    </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
