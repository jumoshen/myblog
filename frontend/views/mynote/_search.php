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

    <?= $form->field($model, 'title')->widget(\kartik\typeahead\Typeahead::className(), [
        'dataset' => [
            [
                'local' => Mynote::myNotesArray(),
                'limit' => 10
            ]
        ],
        'pluginOptions' => ['highlight' => true],
        'options' => ['placeholder' => 'Filter as you type ...'],
    ])?>

    <?= $form->field($model, 'link') ?>

    <?= $form->field($model, 'create_at')->widget(\kartik\date\DatePicker::className(), [
        //'language' => 'ru',
        'pluginOptions' => ['dateFormat' => 'yyyy-MM-dd',]
    ]) ?>

    <?php // echo $form->field($model, 'author') ?>

    <div class="form-group">
        <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
    </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
