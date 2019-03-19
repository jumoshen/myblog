<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\controllers\BaseController;
use backend\models\Menu;

require_once 'wx/example/jssdk.php';
require_once 'wx/lib/WxPay.Config.php';

require_once "wx/lib/WxPay.Api.php";
require_once "wx/example/WxPay.JsApiPay.php";
require_once 'wx/example/log.php';
/**
 * UserController implements the CRUD actions for User model.
 */
class WechatTestController extends BaseController
{
    public function actionTest(){
        $jssdk = new \JSSDK(\WxPayConfig::APPID, \WxPayConfig::APPSECRET);
        $signPackage = $jssdk->getSignPackage();
        return $this->render('test', [
            'signPackage' => $signPackage
        ]);
    }

    //创建自定义菜单
    public function actionCreateMenu(){
        $frontendUrl = Yii::$app->params['frontendUrl'];
        $menu        = new Menu(\WxPayConfig::APPID, \WxPayConfig::APPSECRET);
        $menuArray   = array(
                "button"=>array(
                                array(
                                    // "name"=>$this->unicode2utf8('\ue045')."教程",
                                    "name"=>"教程",
                                    "sub_button"=>array(
                                         array(
                                                 "type"=>"view",
                                                 "name"=>"教程",
                                                 "url"=>"{$frontendUrl}"
                                         )                                    
                                     ),

                                ),
                                array(
                                     // "name"=>$this->unicode2utf8('\ue12f')."笔记",
                                     "name"=>"笔记",
                                     "sub_button"=>array(
                                         array(
                                                 "type"=>"view",
                                                 "name"=>"我的笔记",
                                                 "url"=>"{$frontendUrl}mynote/index.html"
                                         ),                                 
                                     ),
                                ),

                                array(
                                    // "name"=>$this->unicode2utf8('\ue045')."我的",
                                    "name"=>"我的",
                                     "sub_button"=>array(
                                         array(
                                                 "type"=>"view",
                                                 "name"=>"个人中心",
                                                 "url"=>"{$frontendUrl}user/view.html"
                                         )                                   
                                     ),

                                ),

                ),
             );
        $menuData    = json_encode($menuArray, JSON_UNESCAPED_UNICODE);
        $wechatObj   = new \JSSDK(\WxPayConfig::APPID, \WxPayConfig::APPSECRET);
        $accessToken = $wechatObj->getAccessToken();

        $createUrl   = $menu->weChatMenuUrl."create?access_token=".$accessToken;

        $resultJson  = self::httpRequest($createUrl, $menuData);
        $result      = json_decode($resultJson);
        if($result->errcode == 0){
            $message = "菜单创建成功";
        }
        echo '<pre>';
        var_dump($result);die;
    }

    /**
     * 字符转换
     * @param string $str
     * @return string
     */
    private function unicode2utf8($str) { 
            $str = '{"result_str":"' . $str . '"}'; 
            $strarray = json_decode ( $str, true ); 
            return $strarray ['result_str'];
     }  

    public function actionUserInfo(){
        echo '<pre>';
        $tools = new \JsApiPay();
        //获取微信身份标识
        $openId = $tools->GetOpenid();
        $wechatObj = new \JSSDK(\WxPayConfig::APPID, \WxPayConfig::APPSECRET);
        $accessToken = $wechatObj->getAccessToken();
        //获取用户详情
        $dataInfo = json_decode(
                        file_get_contents(
                            "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$accessToken&openid=$openId&lang=zh_CN"
                        )
                    , true);

        var_dump($dataInfo);
    }

    public function actionTools(){
        $wechatObj = new \JSSDK(\WxPayConfig::APPID, \WxPayConfig::APPSECRET);
        $accessToken = $wechatObj->getAccessToken();
        $ipInfo = json_decode(
                        file_get_contents(
                            "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=$accessToken"
                        )
                    , true);
        echo '<pre>';
        // echo '微信服务器IP';
        // var_dump($ipInfo);
        echo '<hr>';
        //获取用户列表
        $usersInfo = json_decode(
                        file_get_contents(
                            "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$accessToken"
                        )
                    , true);

        $userInfo = array();
        if ($usersInfo['count'] > 0 && $usersInfo['count'] < 10000) {
            if (!empty($usersInfo['data']['openid'])) {
                foreach ($usersInfo['data']['openid'] as $key => $value) {
                    $userInfo[$key] = json_decode(
                        file_get_contents(
                            "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$accessToken&openid=$value&lang=zh_CN"
                        )
                    , true);
                }
            }
        }

        if (!empty($userInfo)) {
            echo '<table  border="1" cellspacing="0">';
                foreach ($userInfo as $key => $user) {
                    echo '<tr>';
                        echo '<td>'.date('Y-m-d H:i:s', $user['subscribe_time']).'</td>';
                        echo '<td>'.$user['nickname'].'</td>';
                        echo '<td>'.($user['sex'] == 1 ? '男' : '女').'</td>';
                        echo '<td><img src="'.$user['headimgurl'].'" width="100%" style="width:100px"></td>';
                        // echo '<td>'..'</td>';
                        // echo '<td>'..'</td>';
                        // echo '<td>'..'</td>';
                    echo '</tr>';
                }
            echo '</table>';
        }

        
    }

    public function actionQrcode(){
        $wechatObj = new \JSSDK(\WxPayConfig::APPID, \WxPayConfig::APPSECRET);
        $accessToken = $wechatObj->getAccessToken();
        $qrcode = self::httpRequest(
                        "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$accessToken", 
                        '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 2121}}}'
                    );
        $qrcodeInfo = json_decode($qrcode, true);
        $ticket = urlencode($qrcodeInfo['ticket']);
        echo '<img src="'."https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=$ticket".'">';
    }
}