<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico"/>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        #'brandLabel' => Yii::t('common','Blog of Jumoshen'),
        'brandLabel' => 'Blog of Jumoshen',
        ## 'brandLabel' => '<img src="/images/logo/logo.png.png" alt="" height="100%">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '首页', 'url' => ['/site/index']],
    ];

    foreach(Yii::$app->params['webMenu'] as $key => $value){
        $menuItems[] = [
		'label' => $value, 
		'url' => Url::to(['site/index', 'type' => $key]),
		'options'=> ['class'=>yii::$app->controller->action->id == "course:".$key ? "active" : ""]
	];
    }

    $menuItems[] = ['label' => '我的笔记','url' => ['/mynote/index']];

    $menuItems[] = [
        'label' => '关于本站',
        'items' => [
            ['label' => '关于我们', 'url' => ['/site/about']],
            ['label' => '联系我们', 'url' => ['/site/contact']],
	    ['label' => '网站时间轴', 'url' => ['/tool/web-time-axis']],
        ],
    ];

    if (Yii::$app->user->isGuest) {
        $menuItems_right[] = ['label' => '注册', 'url' => ['/site/signup']];
        $menuItems_right[] = ['label' => '登录', 'url' => ['/site/login']];
    } else {
        $menuItems_right[] = [
            'label' => '<img height="30px" src="'.(!(Yii::$app->user->identity->head_avatar) ? '/head_portrait/default.jpg' : Yii::$app->params['frontendUrl'].Yii::$app->user->identity->head_avatar).'">',
            'items' => [
                ['label' => '个人中心', 'url' => ['/user/view']],
                ['label' => '聊天室', 'url' => ['/user/my-chat-room']],
                ['label' => '退出', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
             ],
         ];

        
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems_right,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Blog of Jumoshen <?= date('Y') ?>&nbsp;京ICP备16019475号-1</p>
	<p class="pull-right">
	    <!--<img class="img-responsive" height="40px"  src="https://s11.flagcounter.com/count2/CM9Y/bg_FFFFFF/txt_000000/border_CCCCCC/columns_2/maxflags_10/viewers_0/labels_0/pageviews_0/flags_0/percent_0/" alt="Flag Counter" border="0">-->
	</p>
    </div>
</footer>

<!--    模态提示框-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>
<!--    结束-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
