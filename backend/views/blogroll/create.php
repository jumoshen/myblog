<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\BlogRoll */

$this->title = 'Create Blog Roll';
$this->params['breadcrumbs'][] = ['label' => 'Blog Rolls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-roll-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
