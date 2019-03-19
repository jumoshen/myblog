<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ActivityPaperCouponController implements the CRUD actions for ActivityPaperCoupon model.
 */
define("TOKEN", "lianghui");

class TokenController extends Controller
{

    public function actionValid()
    {   
        $echoStr = '';
        $echoStr = $_GET["echoStr"];

        //valid signature , option
        if($this->checkSignature()){
		ob_clean();
                echo $echoStr;
                exit;
        }
    }


        private function checkSignature()
        {
            // you must define TOKEN by yourself
            if (!defined("TOKEN")) {
                throw new Exception('TOKEN is not defined!');
            }

            $signature = $_GET["signature"];
            
            $timestamp = $_GET["timestamp"];
            $nonce = $_GET["nonce"];
            $token = TOKEN;
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
