<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StudyCourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '学习教程';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-course-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?php if (Yii::$app->user->can('添加教程')) :?>

    <p>
        <?= Html::a('添加教程', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?php endif; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'visible' => false
            ],

            'course_id',
            'course_title',
	    [
                 'attribute' => 'course_cover',
                 'format' => 'raw',
                 'value' => function($model){
                     return $model->getCover();
                 }
            ],
            'course_intro',
            // [
            //     'attribute' => 'course_detail',
            //     'format' => ['raw',['width'=>'70','height'=>'70',]],
            //     'value' => function($model){
            //         return html_entity_decode(strip_tags($model->course_detail, '<img>'));
            //     }
            // ],
            [
                'attribute' => 'course_type',
                'value' => function($model){
                    return $model->getType();
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function($model){
                    if(!empty($model->created_at)) return date('Y-m-d H:i:s', $model->created_at);
                },
            ],
            [
                'attribute' => 'user_id',
                'value' => function($model){
                    if(!empty($model->user)) return $model->user->username;
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'{view} {update} {delete} {check}',
                'buttons' => [
                    // 下面代码来自于 yii\grid\ActionColumn 简单修改了下
                    'view' =>function ($url, $model, $key) {                  
                            return !\Yii::$app->user->can('查看教程') ?  '' : Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url);
                        },
                    'update' =>function ($url, $model, $key) {                  
                            return !\Yii::$app->user->can('编辑教程') ?  '' : Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
                        },
                    'delete' =>function ($url, $model, $key) {
                        $options = [
                            'onclick' =>'return confirm("确定删除吗？");'
                        ];                    
                            return !\Yii::$app->user->can('删除教程')  ?  '' : Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                        },  
            
                ],
            ],
        ],
    ]); ?>

</div>
<?php  
    $this->registerJsFile('/my-layer/layer.js',['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('/my-layer/layer-min.js',['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('/my-layer/extend/layer.ext.js',['depends' => [\yii\web\JqueryAsset::className()]]);

    $js = <<<JS
    layer.ready(function(){
        layer.photos({
            photos: '.image-review'
        });
    });
JS;
    $this->registerJs($js);
?>
