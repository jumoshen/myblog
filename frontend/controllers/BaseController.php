<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Session;

// require_once "wx/lib/WxPay.Api.php";
// require_once "wx/example/WxPay.JsApiPay.php";
// require_once 'wx/example/log.php';


/**
 * Base controller
 */
class BaseController extends Controller
{
    
    public function beforeAction($action) {
        parent::beforeAction($action);
        
        return true;
    }

    /**
    * http请求及获取请求结果
    * @param string $url 目标url
    * @param array  要提交的数据
    * @return string  请求结果
    */
    public static function httpRequest( $url, $data = null){
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_TIMEOUT, 50);
       if(!is_null($data)){
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);           
       }
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       $result = curl_exec($ch);
       curl_close($ch);
       return $result;
    }
}
