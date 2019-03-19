<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Wechat;
use yii\filters\VerbFilter;

/**
 * ActivityPaperCouponController implements the CRUD actions for ActivityPaperCoupon model.
 */
class TokenController extends Controller
{
    public function actionValid(){

        $wechatObj = new Wechat("lianghui");
        if(isset($_GET["echostr"])){
            $wechatObj->valid();
            
        }

    }
}

?>

