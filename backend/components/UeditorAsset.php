<?php
namespace backend\components;
 
use yii\web\AssetBundle;
 
class UeditorAsset extends AssetBundle
{
    public $js = [
        'ueditor.config.js',
        'ueditor.all.js',
    ];
    public $css = [
    ];
    public function init()
    {
        $this->sourcePath =$_SERVER['DOCUMENT_ROOT'].\Yii::getAlias('@web').'/js'; //设置资源所处的目录
    }
}
