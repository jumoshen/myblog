<?php
namespace backend\models;
/* 
 * 自定义菜单操作类
 */

class Menu{
    
        /*
         * 菜单操作url
         */
        public $weChatMenuUrl = "https://api.weixin.qq.com/cgi-bin/menu/";    
 
        /**
         * 构造函数
         */
        public function __construct($appID, $appSecret) {
            $this->CorpID       = $appID;
            $this->corpsecret   = $appSecret;
        }
        
        /**
         * 创建自定义菜单
         * @param int  $agentID 应用ID
         * @param string $menuData 菜单数据
         */
        public function createMenu( $menuData, $accessToken){
            $createUrl = $this->weChatMenuUrl."create?access_token=".$accessToken;
            return self::httpRequest( $createUrl, $menuData);
        }
        
        
}