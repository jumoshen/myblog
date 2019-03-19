<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                'value' => function($model){
                    return $model->getSex();
                }
            ],
            'province',
            'mobile',
            [
                'attribute' => 'head_avatar',
                'format' => ['image',['width'=>'70','height'=>'70',]],
                'value' => function($model){
                    return $model->getHeadAvatar();
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete} {check}',
                'buttons' => [
                    // 下面代码来自于 yii\grid\ActionColumn 简单修改了下
                    'view' =>function ($url, $model, $key) {                  
                            return !\Yii::$app->user->can('查看用户') ?  '' : Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                        },
                    'update' =>function ($url, $model, $key) {                  
                            return !\Yii::$app->user->can('编辑用户') ?  '' : Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                        },
                    'delete' =>function ($url, $model, $key) {
                        $options = [
                            'onclick' =>'return confirm("确定删除吗？");'
                        ];                    
                            return !\Yii::$app->user->can('删除用户')  ?  '' : Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                        },  
            
                ],
            ],
        ],
    ]); ?>

</div>
