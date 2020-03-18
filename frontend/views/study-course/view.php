<?php
use yii\helpers\Url;
use kartik\markdown\MarkdownEditor;
use kartik\markdown\Markdown;

$this->title = $model['course_title'];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .page-title h1 {
        font-size: 18px;
        margin: 4px 0 10px;
    }
    .page-title span {
        color: #999;
        font-size: 12px;
        margin-right: 5px;
    }
    .page-title {
        border-bottom: 1px solid #eee;
        margin-bottom: 10px;
        padding-bottom: 5px;
    }
    .page-content {
        border-bottom: 1px solid #eee;
        margin-bottom: 10px;
        min-height: 400px;
    }
    .page-tag {
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
    .page-tag span a {
        background: #5bc0de none repeat scroll 0 0;
        border: 1px solid #5bc0de;
        color: #fff;
        display: inline-block;
        font-size: 12px;
        line-height: 1.2em;
        margin: 0 7px 7px 0;
        padding: 2px 7px;
        transition: all 0.2s ease 0s;
    }
    .page-declare span {
        font-size: 12px;
        background: #c9394a none repeat scroll 0 0;
        border: 1px solid #c9394a;
        color: #fff;
        margin-left: 4px;
        padding: 2px 7px;
    }
</style>
<div class="row">
    <div class="col-lg-9">
        <div class="page-title J_postId" data-id="415">
            <h1><?= $model->course_title; ?></h1>
            <span>作者：<a href="#"><?= !empty($model->user) ? $model->user->username : ''; ?></a></span>
            <span>发布于：<?= date('Y-m-d H:i:s',$model->created_at);?></span>
            <span>浏览：<?= $model->views;?>次</span>
            <span>分类：PHP</span>
        </div>

        <div class="page-content" style="word-break:break-all">
            <p><?= $model->course_intro;?></p>
            <?= $model->course_detail;?>
        </div>
        <div class="page-tag">
            <b>标签：</b>
                <?php foreach ($model->tags as $tag): ?>
                    <span><a href="#"><?= $tag;?></a></span>
                <?php endforeach ?>

            <div class="page-declare">
                <b>声明：</b><span>文章内容由作者原创或整理，转载请标明出处！</span>
            </div>
            <div class="bdsharebuttonbox">
                <a href="#" class="bds_more" data-cmd="more"></a>
                <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
                <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
            </div>
        </div>

	<!--PC和WAP自适应版-->
        <div id="SOHUCS" sid="<?= $model->course_id;?>"></div>
        <script type="text/javascript">
            (function () {
                var appid = 'cytjAuGuu';
                var conf = 'prod_870022d974db54a56fa85b8635e90ab9';
                var width = window.innerWidth || document.documentElement.clientWidth;
                if (width < 960) {
                    window.document.write('<script id="changyan_mobile_js" charset="utf-8" type="text/javascript" src="https://changyan.sohu.com/upload/mobile/wap-js/changyan_mobile.js?client_id=' + appid + '&conf=' + conf + '"><\/script>');
                } else {
                    var loadJs = function (d, a) {
                        var c = document.getElementsByTagName("head")[0] || document.head || document.documentElement;
                        var b = document.createElement("script");
                        b.setAttribute("type", "text/javascript");
                        b.setAttribute("charset", "UTF-8");
                        b.setAttribute("src", d);
                        if (typeof a === "function") {
                            if (window.attachEvent) {
                                b.onreadystatechange = function () {
                                    var e = b.readyState;
                                    if (e === "loaded" || e === "complete") {
                                        b.onreadystatechange = null;
                                        a()
                                    }
                                }
                            } else {
                                b.onload = a
                            }
                        }
                        c.appendChild(b)
                    };
                    loadJs("https://changyan.sohu.com/upload/changyan.js", function () {
                        window.changyan.api.config({appid: appid, conf: conf})
                    });
                }
            })(); 
        </script>

	<!--<div class="page-comments">
            <div id="comments">
                <div class="page-header">共<span style="color: red">2</span>条评论</div>
                <ul id="w1" class="media-list">
                    <li class="media">
                        <div class="media-left">
                            <a href=""><img class="media-object" src="/images/slider-images/desk1.jpg" alt=""></a>
                        </div>
                        <div class="media-body">
                            <div class="media-heading">shine 评论于2017-08-08 00:00:00</div>
                            <div class="media-content">这是一个死回复</div>
                            <div class="media-action">
                                <a class="reply" href="javascript:void(0);"><i class="fa fa-reply"></i> 回复</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
	    <div id="comment">
                <div class="page-header">发表评论</div>
                <?= MarkdownEditor::widget([
                    'model' => $model,
                    'attribute' => 'course_intro',
                ]);?>
            </div>
        </div>-->
    </div>
    <div class="col-lg-3"  >
        <div style="margin-bottom: 20px">
            <!-- <a class="btn btn-success btn-block btn-post" href="">
                <i class="icon-plus"></i> 创建文章
            </a>   
            <a class="btn btn-info btn-block btn-post" href="">
                <i class="icon-edit"></i> 编辑文章
            </a> -->
            <a class="btn btn-success btn-block btn-post">
                <i class="icon-plus"></i> 暂留位置！--请勿随意修改
            </a>
        </div>

        <script>
            window._bd_share_config = {
                "common": {
                    "bdSnsKey": {},
                    "bdText": "",
                    "bdMini": "2",
                    "bdPic": "",
                    "bdStyle": "0",
                    "bdSize": "16"
                },
                "share": {},
                "image": {
                    "viewList": ["qzone", "tsina", "tqq", "renren", "weixin"],
                    "viewText": "分享到：",
                    "viewSize": "16"
                }
            };
            with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~ ( - new Date() / 36e5)];
        </script>
        
    </div>
</div>
