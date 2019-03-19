<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "region".
 *
 * @property integer $region_id
 * @property string $name
 * @property string $parent_id
 * @property string $level_type
 */
class Region extends \yii\db\ActiveRecord
{   
    /*
     * 中国编码
     */
    const  CHINA = 100000;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parent_id', 'level_type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'region_id' => 'Region ID',
            'name' => 'Name',
            'parent_id' => 'Parent ID',
            'level_type' => 'Level Type',
        ];
    }

    /**
     * 获取指定区域的下级地区数组
     * @param int 父ID 
     * @return array 地区数组
     */
    public static function getChild($parentID){
        $rsArray = array(''=>'请选择');
        $rs = Region::findAll(["parent_id" => $parentID]);
        foreach ($rs as $row) {
            $rsArray[$row->region_id] = $row->name;
        }
        return $rsArray;
    }
}
