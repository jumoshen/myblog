<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MynoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '我的笔记';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mynote-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?php if (Yii::$app->user->can('添加笔记')): ?>
        <p>
            <?= Html::a('添加笔记', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php endif ?>
    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'link',
            [
                'attribute' => 'create_at',
                'value' => function($model){
                    return date('Y-m-d H:i:s', $model->create_at);
                }
            ],
            [
                'attribute' => 'update_at',
                'value' => function($model){
                    return date('Y-m-d H:i:s', $model->update_at);
                }
            ],
            'author',

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {delete}',
                'buttons' => [
                    // 下面代码来自于 yii\grid\ActionColumn 简单修改了下
                    'update' =>function ($url, $model, $key) {                  
                            return !\Yii::$app->user->can('编辑笔记') ?  '' : Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                        },
                    'delete' =>function ($url, $model, $key) {
                        $options = [
                            'onclick' =>'return confirm("确定删除吗？");'
                        ];                    
                            return !\Yii::$app->user->can('删除笔记')  ?  '' : Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                        },  
            
                ],
            ],
        ],
    ]); ?>

</div>
