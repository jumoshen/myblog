<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Mynote */

$this->title = '添加笔记';
$this->params['breadcrumbs'][] = ['label' => '我的笔记', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mynote-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
