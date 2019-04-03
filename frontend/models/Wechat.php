<?php
namespace frontend\models;
use yii\helpers\Url;
/**
  * wechat php 
  */

class Wechat
{
    private $token = null;
    
    public function __construct($token) {
        $this->token = $token;
    }
    
    public function valid(){
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }  
    
    private function checkSignature(){  
      $signature = $_GET["signature"];
      $timestamp = $_GET["timestamp"];
      $nonce = $_GET["nonce"];
  		
      $token = $this->token;
      $tmpArr = array($token, $timestamp, $nonce);
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
