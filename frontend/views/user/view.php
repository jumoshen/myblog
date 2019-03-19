<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('修改个人信息', ['update'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'username',
            
            'email:email',
            
            [
                'attribute' => 'created_at',
                'value' => !empty($model->created_at) ? date('Y-m-d H:i:s', $model->created_at) : '',
            ],
            [
                'attribute' => 'updated_at',
                'value' => !empty($model->updated_at) ? date('Y-m-d H:i:s', $model->updated_at) : '',
            ],
            'nickname',
            'realname',
            [
                'attribute' => 'sex',
                'value' => $model->getSex(),
            ],
            'province',
            'mobile',

            [
                'attribute'=>'head_avatar',      
                'format' => ['image',['width'=>'70','height'=>'70',]],
                'value' => $model->getHeadAvatar(),
            ],
        ],
    ]) ?>

</div>
