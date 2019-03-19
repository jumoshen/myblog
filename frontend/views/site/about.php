<?php
     
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>本网站因时间原因正在蜗速开发中,请耐心关注后续更新...</p>
    <p>email:1173240549@qq.com</p>
    <p>我的测试公众号</p>
    <div class="col-lg-3">
        <img src="/images/my-wechat-qrcode.jpg" alt="" width="100%">
    </div>
</div>
