<?php
header('content-type:text.html;charset=utf-8');
/**
  * wechat php test
  */

//define your token
define("TOKEN", "lianghui");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();

class wechatCallbackapiTest
{
	public function valid()
    {
        //valid signature , option
        if(isset($_GET["echostr"])){
            $echoStr = $_GET["echostr"];
            if($this->checkSignature()){
                echo $echoStr;
                exit;
            } 
        }else{
            $this->responseMsg();
        }
        
    }

    //回复消息
    public function responseMsg(){
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        file_put_contents("uploads/a.log", $postStr);
        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);

            switch ($RX_TYPE)
            {
                case "text":
                    $resultStr = $this->receiveText($postObj);
                    break;
                case "image":
                    $resultStr = $this->receiveImage($postObj);
                    break;
                case "location":
                    $resultStr = $this->receiveLocation($postObj);
                    break;
                case "voice":
                    $resultStr = $this->receiveVoice($postObj);
                    break;
                case "video":
                    $resultStr = $this->receiveVideo($postObj);
                    break;
                case "link":
                    $resultStr = $this->receiveLink($postObj);
                    break;
                case "event":
                    $resultStr = $this->receiveEvent($postObj);
                    break;
                default:
                    $resultStr = "unknow msg type: ".$RX_TYPE;
                    break;
            }
            echo $resultStr;
        }else {
            echo "";
            exit;
        }
    }
    
    //接收文本消息
    private function receiveText($object)
    {
        $contentStr = trim($object->Content);
        if (strstr($contentStr, "你好")){
            $resultStr = $this->transmitText($object, 'hello! can I help you?');
        }else{
            $resultStr = $this->transmitText($object, $contentStr);
        }
        return $resultStr;
    }

    
    //接收事件，关注等
    private function receiveEvent($object)
    {
        $contentStr = "";
        switch ($object->Event)
        {
            case "subscribe":
                $contentStr = "感谢您关注【巨魔深】";    //关注后回复内容
                break;
            case "unsubscribe":
                $contentStr = "";
                break;
            case "CLICK":
                $contentStr =  '';    //点击事件
                break;
            default:
                $contentStr = "receive a new event: ".$object->Event;
                break;
        }
        $result = $this->transmitText($object, $contentStr);
        
        return $result;
    }
    
    //接收图片
    private function receiveImage($object)
    {
        $contentStr = "你发送的是图片，地址为：".$object->PicUrl;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }
    
    
    //接收语音
    private function receiveVoice($object)
    {
        $contentStr = "你发送的是语音，媒体ID为：".$object->MediaId;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }
    
    //接收视频
    private function receiveVideo($object)
    {
        $contentStr = "你发送的是视频，媒体ID为：".$object->MediaId;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }
    
    //位置消息
    private function receiveLocation($object)
    {
        $contentStr = "你发送的是位置，纬度为：".$object->Location_X."；经度为：".$object->Location_Y."；缩放级别为：".$object->Scale."；位置为：".$object->Label;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }
    
    //链接消息
    private function receiveLink($object)
    {
        $contentStr = "你发送的是链接，标题为：".$object->Title."；内容为：".$object->Description."；链接地址为：".$object->Url;
        $resultStr = $this->transmitText($object, $contentStr);
        return $resultStr;
    }
    
    
   //点击菜单消息
    private function receiveClick($object)
    {
         switch ($object->EventKey)
         {
             case "1":
             $contentStr = "1";
             break;
             
             case "2":


             $contentStr = "你点击了菜单: ".$object->EventKey;
             break;
             
             case "3":
             $contentStr = "是傻逼";
             break;
             
             default:
             $contentStr = "你点击了菜单: ".$object->EventKey;
             break;
         }
        
        
        //两种回复
        if (is_array($contentStr)){
            $resultStr = $this->transmitNews($object, $contentStr);
        }else{
            $resultStr = $this->transmitText($object, $contentStr);
        }
        return  $resultStr;
    }
    
    //回复文本消息
    private function transmitText($object, $content)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $resultStr;
    }    
    
    
    
    
    //回复图文--暂未使用
    private function transmitNews($object, $arr_item)
    {
        if(!is_array($arr_item))
            return;
        $itemTpl = "<item>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                    <PicUrl><![CDATA[%s]]></PicUrl>
                    <Url><![CDATA[%s]]></Url>
                    </item>";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);
        $newsTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[news]]></MsgType>
                    <Content><![CDATA[]]></Content>
                    <ArticleCount>%s</ArticleCount>
                    <Articles>
                    $item_str</Articles>
                    </xml>";
        $resultStr = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item));
        return $resultStr;
    }

    //发送图文消息   //现阶段使用中
    public static function responseNews($postObj, $title, $description, $PicUrl, $Url){
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $time = time();
                $textTpl = "<xml>
                              <ToUserName><![CDATA[%s]]></ToUserName>
                              <FromUserName><![CDATA[%s]]></FromUserName>
                              <CreateTime>%s</CreateTime>
                              <MsgType><![CDATA[%s]]></MsgType>
                              <ArticleCount>1</ArticleCount>
                              <Articles>
                              <item>
                              <Title><![CDATA[%s]]></Title> 
                              <Description><![CDATA[%s]]></Description>
                              <PicUrl><![CDATA[%s]]></PicUrl>
                              <Url><![CDATA[%s]]></Url>
                              </item>
                              </Articles>
                              </xml>";             

                $msgType = "news";
                
                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType,$title,$description,$PicUrl,$Url);
                echo $resultStr;
    }
    
    
    //音乐消息
    private function transmitMusic($object, $musicArray, $flag = 0)
    {
        $itemTpl = "<Music>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                    <MusicUrl><![CDATA[%s]]></MusicUrl>
                    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                    </Music>";
        $item_str = sprintf($itemTpl, $musicArray['Title'], $musicArray['Description'], $musicArray['MusicUrl'], $musicArray['HQMusicUrl']);
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[music]]></MsgType>
                    $item_str
                    <FuncFlag>%d</FuncFlag>
                    </xml>"; 
       $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $flag);
        return $resultStr;
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

?>