<?php
use yii\helpers\Url;

$this->registerJsFile('/my-layer/layer.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('/js/web-time-axis.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('/css/web-time-axis.css', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<div class="head-warp">
    <div class="head">
        <div class="nav-box">
            <ul>
                <li class="cur" style="text-align:center; font-size:50px; font-family:'微软雅黑', '宋体';"></li>
            </ul>
        </div>
    </div>
</div>
<div class="main">
    <div class="history">
        <?php foreach ($timeArray as $key => $times): ?>
            <div class="history-date">
                <ul>
                    <h2 class="first"><a href="#nogo"><?= $key; ?>年</a></h2>
                    <?php foreach ($times as $time): ?>
                        <li class="green">
                            <h3><?= date('m.d', $time['created_at']) ?><span><?= $key; ?></span></h3>
                            <dl>
                                <dt>
                                    <span><?= $time['course_title']; ?></span>
                                </dt>
                            </dl>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endforeach ?>
    </div>
</div>


