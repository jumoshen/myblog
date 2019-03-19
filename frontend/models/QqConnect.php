<?php
namespace frontend\models;

use Yii;
use yii\web\Session;
/**
  * QqConnect
  */

class QqConnect
{
    const CLIENT_ID = '101398718';
    const APP_KEY = '5e55460264f9e8f8f92c15a2e1ebecdc';
    const REDIRECT_URL = 'http://www.jumoshen.cn';

    public static function getCode($redirectUrl){
        $state = md5(uniqid(rand(), TRUE));
        $session = new Session();
        $session['state'] = $state;

        $url = 'https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id='.self::CLIENT_ID.'&redirect_uri='.urlencode($redirectUrl).'&state='.$state;
        echo("<script> top.location.href='" . $url . "'</script>");
    }

    public function getQqAccessToken(){
        $code = \Yii::$app->request->get("code");

        $url = 'https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id='.self::CLIENT_ID.'&client_secret='.self::APP_KEY.'&code='.$code.'&redirect_uri='.urlencode(self::REDIRECT_URL);

        $response = QqConnect::httpRequest($url);

        if(strpos($response, "callback") !== false){
            $lpos     = strpos($response, "(");
            $rpos     = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos -1);
            $message  = json_decode($response);
            if(isset($message->error)){
                $this->showError($message->error, $message->error_description);
            }
        }
        $params = array();
        parse_str($response, $params);
        $session = new Session();

        $session["access_token"] = $params["access_token"];
        return $params["access_token"];
    }

    public function getOpenid(){

        $accessToken = \Yii::$app->session->get('access_token');
        $url = 'https://graph.qq.com/oauth2.0/me?access_token='.$accessToken;
        $response = self::httpRequest($url);

        if(strpos($response, "callback") !== false){
            $lpos = strpos($response, "(");
            $rpos = strrpos($response, ")");
            $response = substr($response, $lpos + 1, $rpos - $lpos -1);
        }
        $user = json_decode($response);
        if(isset($user->error)){
            $this->showError($user->error, $user->error_description);
        }
        //------记录openid
        $session = new Session();
        $session['openid'] = $user->openid;
        return $user->openid;
    }

    /**
     * showError
     * 显示错误信息
     * @param int $code 错误代码
     * @param string $description 描述信息（可选）
     */
    public function showError($code, $description = '$'){
        echo "<meta charset=\"UTF-8\">";
        echo "<h3>error:</h3>$code";
        echo "<h3>msg :</h3>$description";
        exit();
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