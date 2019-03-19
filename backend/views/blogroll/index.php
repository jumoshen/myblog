<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BlogRollSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blog Rolls';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-roll-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php if (\Yii::$app->user->can('添加友情链接')): ?>
        <p>
            <?= Html::a('添加链接', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'web_name',
            'link',
            'web_logo_link',
            'qq',
            'email:email',
            'remark',
            'is_checked',
            [
                'attribute' => 'apply_time',
                'value' => function($model){
                    return date('Y-m-d H:i:s', $model->apply_time);
                }
            ],
            [
                'attribute' => 'pass_time',
                'value' => function($model){
                    return date('Y-m-d H:i:s', $model->pass_time);
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete} {check}',
                'buttons' => [
                    // 下面代码来自于 yii\grid\ActionColumn 简单修改了下
                    'view' =>function ($url, $model, $key) {
                        return !\Yii::$app->user->can('查看友情链接') ?  '' : Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                    },
                    'update' =>function ($url, $model, $key) {
                        return !\Yii::$app->user->can('编辑友情链接') ?  '' : Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                    },
                    'delete' =>function ($url, $model, $key) {
                        $options = [
                            'onclick' =>'return confirm("确定删除吗？");'
                        ];
                        return !\Yii::$app->user->can('删除友情链接')  ?  '' : Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                    },
                    'check' =>function ($url, $model, $key) {
                        return (\Yii::$app->user->can('审核友情链接') && !$model->is_checked) ?  Html::a('<span class="glyphicon glyphicon-check"></span>', $url) : '';
                    },

                ],
            ],
        ],
    ]); ?>
</div>
