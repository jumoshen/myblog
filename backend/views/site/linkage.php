<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use backend\models\Region;
use yii\helpers\Url;
?>

<?php $form = ActiveForm::begin(); ?>
	<?php
		$url = Url::to(['site/get-regions']);
	?>
	<?= $form->field($model, 'course_title')->dropDownList(Region::getChild(Region::CHINA),[
	    'onchange'=>'
	        $.post("/site/get-regions.html?id='.'"+$(this).val(),function(data){

	            $("select#studycourse-course_intro").html(data);
	        });',
	]) ?>

	<?= $form->field($model, 'course_intro')->dropDownList(Region::getChild($model->course_title),[
	    'onchange'=>'
	        $.post("/site/get-regions.html?id='.'"+$(this).val(),function(data){
	            $("select#studycourse-course_detail").html(data);
	        });',
	]) ?>

	<?= $form->field($model, 'course_detail')->dropDownList(Region::getChild($model->course_intro))  ?>
<?php ActiveForm::end(); ?>