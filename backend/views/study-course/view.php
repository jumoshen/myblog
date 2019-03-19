<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\StudyCourse */

$this->title = $model->course_id;
$this->params['breadcrumbs'][] = ['label' => '学习教程', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-course-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can('编辑教程')) :?>
        <?= Html::a('更新', ['update', 'id' => $model->course_id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>

        <?php if (Yii::$app->user->can('删除教程')) :?>
        <?= Html::a('删除', ['delete', 'id' => $model->course_id], [
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
            'course_id',
            'course_title',
	    [
                'attribute' => 'course_cover',
                'format' => 'raw',
                'value' => $model->getCover(),
            ],
            'course_intro',
            [
                'attribute' => 'course_detail',
                'format' => 'raw',
                'value' => $model->course_detail,
            ],
            [
                'attribute' => 'course_type',
                'value' => $model->getType(),
            ],
            [
                'attribute' => 'created_at',
                'value' => !empty($model->created_at) ? date('Y-m-d H:i:s', $model->created_at) : '',
            ],
            [
                'attribute' => 'user_id',
                'value' => !empty($model->user) ? $model->user->username : '',
            ],
            'tags'
        ],
    ]) ?>

</div>
