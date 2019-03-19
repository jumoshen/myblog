<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\StudyCourse */

$this->title = '更新教程: ' . ' ' . $model->course_id;
$this->params['breadcrumbs'][] = ['label' => '学习教程', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->course_id, 'url' => ['view', 'id' => $model->course_id]];
$this->params['breadcrumbs'][] = '更新';
?>
<div class="study-course-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
