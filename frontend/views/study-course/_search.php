<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\StudyCourse;

/* @var $this yii\web\View */
/* @var $model backend\models\StudyCourseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="study-course-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    
    <div class="form-group form-inline">

    <?= $form->field($model, 'course_title') ?>

    <?= $form->field($model, 'course_type')->dropDownList(StudyCourse::allCourseType()) ?>

    <?php //echo $form->field($model, 'created_at') ?>

    <?php echo $form->field($model, 'user_id')->dropDownList(StudyCourse::getUsers()) ?>

    <div class="form-group">
        <?= Html::submitButton('检索', ['class' => 'btn btn-primary']) ?>
    </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
