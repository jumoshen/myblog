<?php
namespace frontend\models;
//服务模型

class Service{
    
    /**
     * 服务密钥配置
     */
    public static function encrptConfig(){
        return array(
            'coffee08'=>array(
                'screct'=>'daE8p5yQbm0U6Nwd',
                'encrypt'=>'50nGI1JW0OHfk8ah',
            )
        );
    }    

    /**
     * 验证服务密钥是否合法
     * @param type $key  应用ID
     * @param type $secretString 加密串
     * @return type
     */
    public static function verifyService($key, $secretString){
        $verifyResult = false;
        $encryptString  = self::getEncryString($key);
        //echo $encryptString;
        $verifyResult   = $secretString === $encryptString;
        return $verifyResult;
    }
    
    /**
     * 获取应用加密
     * @param string $key 应用键值
     * @return string  加密串
     */
    public static function getEncryString($key){
        $config = self::encrptConfig();
        $encryptString  = "";
        if(array_key_exists($key, $config)){
            $screct         = $config[$key]['screct'];
            $encrypt        = $config[$key]['encrypt'];
            $encryptString  = md5($encrypt.$screct);
        }
        return $encryptString;
    }    

}