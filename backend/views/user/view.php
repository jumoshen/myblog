<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '用户管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if (Yii::$app->user->can('编辑用户')) :?>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php endif; ?>

        <?php if (Yii::$app->user->can('删除用户')) :?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php endif;?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'status',
            'created_at',
            'updated_at',
            'nickname',
            'realname',
            [
                'attribute' => 'sex',
                'value' => $model->getSex(),
            ],
            'province',
            'mobile',
            [
                'attribute' => 'head_avatar',
                'format'=> ['image',['width'=>'70','height'=>'70',]],
                'value' => $model->getHeadAvatar(),
            ],
        ],
    ]) ?>

</div>
