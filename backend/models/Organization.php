<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "organization".
 *
 * @property integer $org_id
 * @property string $org_name
 * @property integer $parent_id
 * @property string $parent_path
 * @property string $org_pass
 */
class Organization extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_name', 'parent_id', 'parent_path'], 'required'],
            [['parent_id'], 'integer'],
            [['org_name'], 'string', 'max' => 255],
            [['parent_path', 'org_pass'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'org_id' => 'Org ID',
            'org_name' => '机构名称',
            'parent_id' => 'Parent ID',
            'parent_path' => 'Parent Path',
            'org_pass' => '设备密码',
        ];
    }
    
    /**
     * 获取分公司
     * @return array 分公司数据
     */
    public static function getBranchArray(){
        $parentPath = self::getManagerBranchPath();
        $branchList = self::find()->andFilterWhere(['like','parent_path',$parentPath])->all();
        $allArray = array(
            ''=>'请选择',
        );
        foreach($branchList as $branch){
            $allArray[$branch->org_id] = $branch->org_name;
        }
        return $allArray;
    }
    
    /**
     * 获取登录用户权限路径
     * @param int $orgID 机构ID
     */
    public static function getManagerBranchPath(){
        $orgID = Manager::getManagerBranchID();
        if (($model = Organization::findOne($orgID)) !== null) {
            return $model->parent_path;
        }else{
            return false;
        }
        
    }
}
