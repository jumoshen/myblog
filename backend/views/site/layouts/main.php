<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => '首页',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
            ];     
            
            $menuArray =  array();

            if (Yii::$app->user->can('教程管理'))
                $menuArray[] = ['label' => '教程管理', 'url' => ['/study-course/index']];

            if (Yii::$app->user->can('资料管理')) {
                $menuItems[] = array('label' => '资料管理',
                    'items'=>$menuArray,
                 );
            }
                    
            $menuArray = array();
            if (Yii::$app->user->can('系统设置列表')) 
                $menuArray[] = ['label' => '系统设置', 'url' => ['/sysconfig/index']];             
            if (Yii::$app->user->can('修改密码')) 
                $menuArray[] = ['label' => '修改密码', 'url' => ['/site/change-password']];
            if (Yii::$app->user->can('用户管理')) 
                $menuArray[] = ['label' => '用户管理', 'url' => ['/user/index']]; 
            if (Yii::$app->user->can('角色管理')) 
                $menuArray[] = ['label' => '角色管理', 'url' => ['/role/index']];
            if (Yii::$app->user->can('管理员管理')) 
                $menuArray[] = ['label' => '管理员管理', 'url' => ['/manager/index']];             
            if (Yii::$app->user->can('操作日志')) 
                $menuArray[] = ['label' => '操作日志', 'url' => ['/manager-log/index']];   
            
            if (Yii::$app->user->can('系统设置')) {
                $menuItems[] = array('label' => '系统设置',
                    'items'=>$menuArray,
                 );
            }  

                                    
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => '退出 (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy;Party of JuMo <?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
