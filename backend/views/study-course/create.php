<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\StudyCourse */

$this->title = '添加教程';
$this->params['breadcrumbs'][] = ['label' => '学习教程', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-course-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
