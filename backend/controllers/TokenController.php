<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActivityPaperCouponController implements the CRUD actions for ActivityPaperCoupon model.
 */
class TokenController extends Controller
{
    // define("TOKEN", "weixin");

    const TOKEN = "lianghui";

    public function actionValid()
    {   
        $echoStr = '';
        $echoStr = Yii::$app->request->get("echoStr");

        //valid signature , option
        if($this->checkSignature()){
                echo substr(md5($echoStr),0,16);
                exit;
        }
    }


        private function checkSignature()
        {
            // you must define TOKEN by yourself
            if (!self::TOKEN) {
                throw new Exception('TOKEN is not defined!');
            }

            $signature = Yii::$app->request->get("signature");
            
            $timestamp = Yii::$app->request->get("timestamp");
            $nonce = Yii::$app->request->get("nonce");
            $token = self::TOKEN;
            $tmpArr = array($token, $timestamp, $nonce);
            // use SORT_STRING rule
            sort($tmpArr, SORT_STRING);
            $tmpStr = implode( $tmpArr );
            $tmpStr = sha1( $tmpStr );

            if( $tmpStr == $signature ){
                    return true;
            }else{
                    return false;
            }
        }
}

?>

