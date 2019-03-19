<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Blogroll;

/* @var $this yii\web\View */
/* @var $model backend\models\BlogRoll */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Blog Rolls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-roll-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (\Yii::$app->user->can('编辑友情链接')): ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif ?>

        <?php if (\Yii::$app->user->can('删除友情链接')): ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        <?php endif ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'web_name',
            'link',
            'web_logo_link',
            'qq',
            'email:email',
            'remark',
            [
                'attribute' => 'is_checked',
                'value' => Blogroll::statusArray()[$model->is_checked],
            ],
            [
                'attribute' => 'apply_time',
                'value' => date('Y-m-d H:i:s', $model->apply_time),
            ],
            [
                'attribute' => 'pass_time',
                'value' => date('Y-m-d H:i:s', $model->pass_time),
            ],
        ],
    ]) ?>

</div>
