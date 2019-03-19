<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Mynote */

$this->title = 'Update Mynote: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Mynotes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mynote-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
