<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Blogroll;

/* @var $this yii\web\View */
/* @var $model backend\models\BlogRollSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-roll-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="form-inline form-data">
        <?= $form->field($model, 'web_name') ?>

        <?= $form->field($model, 'qq') ?>

        <?= $form->field($model, 'is_checked')->dropDownList(Blogroll::statusArray()) ?>

        <div class="form-group">
            <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
