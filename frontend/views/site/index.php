<?php

/* @var $this yii\web\View */
use backend\models\StudyCourse;
use yii\helpers\Url;

$this->title = 'blog_of_jumoshen';
?>
<style type="text/css">
    .box-title {
        color: #333;
        font-size: 18px;
        border-bottom: 2px solid #CBCBCB;
        padding-bottom: 5px;
    }
    .tag-cloud a {
        border: 1px solid #ebebeb;
        padding: 2px 7px;
        color: #333;
        line-height: 2em;
        display: inline-block;
        font-size: 14px;
        margin: 0 7px 7px 0;
        transition: all 0.2s ease;
    }
</style>
<meta name="description" content="“巨魔深”，一个属于自己的博客，在这里你可以分享自己的知识，一加一永远大于二" />
<meta name="keywords"  content="巨魔深; 巨魔客; 巨魔; jumoshen; blog_jumo" />
<?php 
    $this->registerCssFile('/css/index.css',['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerCssFile('/css/font-awesome.min.css',['depends' => [\yii\web\JqueryAsset::className()]]);
    //slider-play
    $this->registerCssFile('/css/slider-play/style.css',['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('/js/slider-play/wowslider.js',['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('/js/slider-play/script.js',['depends' => [\yii\web\JqueryAsset::className()]]);
    $this->registerJsFile('/js/slider-play/jquery.js',['depends' => [\yii\web\JqueryAsset::className()]]);

 ?>
 <div class="row">
	<!-- 左侧部分 -->
	<div class="col-lg-9">
	    <!-- 轮播图 -->
	    <div class="panel">
        	<!-- Start WOWSlider.com BODY section --> <!-- add to the <body> of your page -->
	        <div id="wowslider-container1">
        	    <div class="ws_images">
	                <ul>
                	    <li><img src="/images/slider-images/desk1.jpg" alt="responsive slider" title="" id="wows1_0"/></li>
        	            <li><img src="/images/slider-images/q8r7w_kz9pvirp_wy.png" alt="`Q8R7W}_K(Z9PV]{I@RP_WY" title="" id="wows1_1"/></li>
	                    <li><img src="/images/slider-images/desk1.jpg" alt="responsive slider" title="" id="wows1_2"/></li>

                	</ul>
        	    </div>

	        </div>  

        	<!-- End WOWSlider.com BODY section -->
    	</div>
    
        最新文章
        <!-- 最新教程 -->
        <div class="panel">
            <div class="news">
                <?php foreach ($courses['data'] as $key => $course): ?>
                    <div class="panel-body border-bottom">      
                        <div class="row">
                            <div class="col-lg-4 label-img-size">
                                <a href="#" class="post-label">
                                    <img src="<?= Yii::$app->params['backendUrl'].$course->course_cover;?>" alt="" style="width:100%;overflow:hidden">
                                </a>
                            </div>
                            <div class="col-lg-8 btn-group">
                                <h1>
                                    <a href="<?= Url::to(['study-course/view', 'id' => $course->course_id])?>">
                                        <?= $course->course_title?>
                                    </a>&nbsp;
                                    <span class="cat">
                                        [<?= $course->course_type; ?>]
                                    </span>
                                    <span class="top">置顶</span>
                                </h1>
                                <span class="post-tags">
                                    <span class="glyphicon glyphicon-user"></span><a href=""><?= $course->user_id?></a>&nbsp;
                                    <span class="glyphicon glyphicon-time"></span><?= date('Y-m-d', $course->created_at);?>&nbsp;
                                    <span class="glyphicon glyphicon-eye-open"></span><?= $course->views?>&nbsp;
                                    <span class="glyphicon glyphicon-comment"></span></span> <span id= "sourceId::<?= $course->course_id?>" class = "cy_cmt_count" ></span>
<script id="cy_cmt_num" src="https://changyan.sohu.com/upload/plugins/plugins.list.count.js?clientId=cytjAuGuu">
</script>

                                <p class="post-content"><?= mb_substr(strip_tags($course->course_detail), 0, 150, 'utf-8').'...' ?></p>

                                <a href="<?= Url::to(['study-course/view', 'id' => $course->course_id])?>"><button class="btn btn-warning no-radius btn-sm pull-right">阅读全文</button></a>
                            </div>
                        </div>
                    </div>
                    <div class="tags">
                        <?php foreach($course['tags'] as $tag):?>
                            <a href="#"><?= $tag?></a>，
                        <?php endforeach;?>
                    </div>
                <?php endforeach ?>
                <?= $courses['pagination']?>
            </div>
        </div>
    </div>
    
    <!-- 右侧部分 -->
    <div  class="col-lg-3">
        最新动态
        <!-- 最新动态 -->
        <div class="panel">
            <div class="news">
                <div class="panel-body border-bottom">
                    <a href="http://practice.jumoshen.cn">Unit 1</a>
                </div>
                <div class="panel-body border-bottom">
                    <a href="http://practice.jumoshen.cn">Unit 2</a>
                </div>
            </div>
        </div>
    </div>

    <div  class="col-lg-3">
        <!-- 热门标签 -->
        <div class="panel">
            <div class="panel-title box-title">
                <span>Hot Tags</span>
                <span class="pull-right"><a href="" class="font-12">更多»</a></span>
            </div>
            <div class="tag-cloud">
                <?php foreach((new \backend\models\Tag)->getIndexTags() as $tag):?>
                    <a href="<?= Url::to(['site/index', 'tagId' => $tag['id']]);?>"><?= $tag['tag_name'] ?></a>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    
    <!-- 底部 -->
    <div class="col-lg-12 footer">
        <div class="container">
            <div class="friendly-link">
                <span>友情链接：</span>
                <?php foreach((new \backend\models\Blogroll())->getBlogrolls() as $blogroll):?>
                    <a href="<?= $blogroll['link']; ?>" target="_blank" title="<?= $blogroll['web_name']; ?>"><?= $blogroll['web_name']; ?></a>
                <? endforeach ?>
            </div>
        </div>
    </div>
</div>
<?php
$bindUrl = Url::to(['user/bind-email']);

$js = <<<JS
$('.modal-content').html('$modalContent');
    $('#myModal').modal({'show': true});

    $('#do-something').click(function(){
        var bindUrl = '$bindUrl';
        var email = $('input[name=eamil]').val();
        var pattern = /^[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/;

        if(!email){
            layer.msg('请填入邮箱', {icon: 5});
            return false;
        }

        if(!pattern.test(email)){
            layer.msg('邮箱格式错误！', {icon: 5});
            return false;
        }

        $.ajax({
            url: bindUrl,
            type: "post",
            data: {email: email},
            dataType: "json",
            beforeSend: function(){
                layer.ready(function() {
                    layer.load(3);
                })
            },
            success:function(data) {
                setTimeout(function(){
                    layer.closeAll();
                    if(data.code != 200){
                        layer.msg(data.message, {icon: 5});
                    }else{
                        layer.msg('绑定成功！', {icon: 1});
                        $('#myModal').modal('hide');
                    }
                }, 500)

            }
        });
    })
JS;

if(!$isBindEmail){
    $this->registerJs($js);
}
?>
