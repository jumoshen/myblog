<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MynoteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="mynote-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?= Html::a('添加笔记', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',
            'link:url',
            [
                'attribute' => 'create_at',
                'value' => function($model){
                    return date('Y-m-d H:i:s', $model->create_at);
                }
            ],
            [
                'attribute' => 'update_at',
                'value' => function($model){
                    return $model->update_at ? date('Y-m-d H:i:s', $model->update_at) : '暂无更新';
                }
            ],
            'author',

        ],
    ]); ?>

</div>
