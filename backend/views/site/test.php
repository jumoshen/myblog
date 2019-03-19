<?php
use kartik\tabs\TabsX;
use yii\helpers\Url;
use kartik\select2\Select2;
use shiyang\umeditor\UMeditor;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use kartik\markdown\MarkdownEditor;
use kartik\markdown\Markdown;

    $items = [
        [
            'label'=>'<i class="glyphicon glyphicon-home"></i> Home',
            'content'=>'我的选择',
            'active'=>true
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-user"></i> Profile',
            'content'=>'我的选择',
            'linkOptions'=>['data-url'=> Url::to(['/site/tabs-data'])]
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Dropdown',
            'items'=>[
                 [
                     'label'=>'Option 1',
                     'encode'=>false,
                     'content'=>'我的选择',
                 ],
                 [
                     'label'=>'Option 2',
                     'encode'=>false,
                     'content'=>'我的选择',
                 ],
            ],
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-king"></i> Disabled',
            'headerOptions' => ['class'=>'disabled']
        ],
    ];


    $data = [];
    // Above


?>  
<div class="alert alert-success alert-dismissable">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">X</button>
    <?= yii::$app->session->getFlash('success');?>
</div>
<div style="width:50%">
    <?= TabsX::widget([
        'items'=>$items,
        'position'=>TabsX::POS_ABOVE,
        'bordered'=>true,
        'encodeLabels'=>false
    ]);?>

    <?= Select2::widget([
        'name' => 'color_1',
        'value' => [], // initial value
        'data' => $data,
        'options' => ['placeholder' => 'Select a color ...', 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 10
        ],
    ]);?>
    <?= Highcharts::widget([
        'options'=>'{
          "title": { "text": "Fruit Consumption" },
          "xAxis": {
             "categories": ["Apples", "Bananas", "Oranges"]
          },
          "yAxis": {
             "title": { "text": "Fruit eaten" }
          },
          "series": [
             { "name": "Jane", "data": [1, 0, 4] },
             { "name": "John", "data": [5, 7,3] }
          ]
       }'
    ]);?>
    <?= MarkdownEditor::widget([
        'model' => $model, 
        'attribute' => 'created_at',
    ]);?>

    <?= MarkdownEditor::widget([
        'name' => 'markdown', 
        'value' => '',
    ]);?>

    <?= Markdown::convert($content);?>
</div>  
<?php  
    $js = <<<JS
        $('#w3').focus(function(){
            var mdValue = $('#studycourse-created_at').val();
            $('#w3').val(mdValue);       
        })
JS;
    $this->registerJs($js);
?>

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'created_at')->widget(Umeditor::className(), [
        //'options' => [
           // 'style' => 'width:800px'
       // ]
    //]) ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>