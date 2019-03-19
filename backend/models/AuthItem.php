<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 */
class AuthItem extends \yii\db\ActiveRecord
{
    
    /**
     * 超级管理员
     */
    const SUPER_MASTER = "超级管理员";
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            ['name','unique'],
            [['name', 'rule_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '角色名称',
            'type' => 'Type',
            'description' => '角色简介',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
    }
    
    /**
     * 获取权限数组
     */
    public function getRightsArray(){
        return array(
            '1'=>array('id'=>1, 'pId'=>0, 'name'=>'首页管理', 'open'=>true, 'defaultCheck'=>false),
            
            '2'=>array('id'=>2, 'pId'=>0, 'name'=>'资料管理', 'open'=>true, 'defaultCheck'=>false),
            
                '201'=>array('id'=>201, 'pId'=>2, 'name'=>'教程管理', 'defaultCheck'=>false),
                    '20101'=>array('id'=>20101, 'pId'=>201, 'name'=>'添加教程', 'defaultCheck'=>false),
                    '20102'=>array('id'=>20102, 'pId'=>201, 'name'=>'查看教程', 'defaultCheck'=>false),
                    '20103'=>array('id'=>20103, 'pId'=>201, 'name'=>'编辑教程', 'defaultCheck'=>false),
                    '20104'=>array('id'=>20104, 'pId'=>201, 'name'=>'删除教程', 'defaultCheck'=>false), 

                '202'=>array('id'=>202, 'pId'=>2, 'name'=>'笔记管理', 'defaultCheck'=>false),
                    '20201'=>array('id'=>20201, 'pId'=>202, 'name'=>'添加笔记', 'defaultCheck'=>false),
                    '20202'=>array('id'=>20202, 'pId'=>202, 'name'=>'查看笔记', 'defaultCheck'=>false),
                    '20203'=>array('id'=>20203, 'pId'=>202, 'name'=>'编辑笔记', 'defaultCheck'=>false),
                    '20204'=>array('id'=>20204, 'pId'=>202, 'name'=>'删除笔记', 'defaultCheck'=>false),

            '3'=>array('id'=>3, 'pId'=>0, 'name'=>'杂项管理', 'open'=>true, 'defaultCheck'=>false),
                '301'=>array('id'=>301, 'pId'=>3, 'name'=>'友情链接管理', 'defaultCheck'=>false),
                '30101'=>array('id'=>30101, 'pId'=>301, 'name'=>'添加友情链接', 'defaultCheck'=>false),
                '30102'=>array('id'=>30102, 'pId'=>301, 'name'=>'查看友情链接', 'defaultCheck'=>false),
                '30103'=>array('id'=>30103, 'pId'=>301, 'name'=>'编辑友情链接', 'defaultCheck'=>false),
                '30104'=>array('id'=>30104, 'pId'=>301, 'name'=>'删除友情链接', 'defaultCheck'=>false),
                '30105'=>array('id'=>30105, 'pId'=>301, 'name'=>'审核友情链接', 'defaultCheck'=>false),


            '9'=>array('id'=>9, 'pId'=>0, 'name'=>'系统设置', 'open'=>true, 'defaultCheck'=>true),        

                '901'=>array('id'=>901, 'pId'=>9, 'name'=>'系统设置列表', 'defaultCheck'=>false),
                    '90101'=>array('id'=>90101, 'pId'=>901, 'name'=>'编辑系统设置', 'defaultCheck'=>false),
                    '90102'=>array('id'=>90102, 'pId'=>901, 'name'=>'查看系统设置', 'defaultCheck'=>false),
            
                '902'=>array('id'=>902, 'pId'=>9, 'name'=>'修改密码', 'defaultCheck'=>true),

            
                '903'=>array('id'=>903, 'pId'=>9, 'name'=>'角色管理', 'defaultCheck'=>false),
                    '90301'=>array('id'=>90301, 'pId'=>903, 'name'=>'添加角色', 'defaultCheck'=>false),
                    '90302'=>array('id'=>90302, 'pId'=>903, 'name'=>'编辑角色', 'defaultCheck'=>false), 
                    '90303'=>array('id'=>90303, 'pId'=>903, 'name'=>'删除角色', 'defaultCheck'=>false), 
                    '90304'=>array('id'=>90304, 'pId'=>903, 'name'=>'查看角色', 'defaultCheck'=>false), 

                '904'=>array('id'=>904, 'pId'=>9, 'name'=>'管理员管理', 'defaultCheck'=>false),
                    '90401'=>array('id'=>90401, 'pId'=>904, 'name'=>'添加管理员', 'defaultCheck'=>false),
                    '90402'=>array('id'=>90402, 'pId'=>904, 'name'=>'编辑管理员', 'defaultCheck'=>false), 
                    '90403'=>array('id'=>90403, 'pId'=>904, 'name'=>'删除管理员', 'defaultCheck'=>false), 
                    '90404'=>array('id'=>90404, 'pId'=>904, 'name'=>'查看管理员', 'defaultCheck'=>false),  
            
                '905'=>array('id'=>905, 'pId'=>9, 'name'=>'操作日志', 'defaultCheck'=>false),            

                '906'=>array('id'=>906, 'pId'=>9, 'name'=>'用户管理', 'defaultCheck'=>false),
                    '90601'=>array('id'=>90601, 'pId'=>906, 'name'=>'添加用户', 'defaultCheck'=>false),
                    '90602'=>array('id'=>90602, 'pId'=>906, 'name'=>'编辑用户', 'defaultCheck'=>false), 
                    '90603'=>array('id'=>90603, 'pId'=>906, 'name'=>'删除用户', 'defaultCheck'=>false), 
                    '90604'=>array('id'=>90604, 'pId'=>906, 'name'=>'查看用户', 'defaultCheck'=>false),
           
        );
    }
    
    /**
     * 获取权限树字串
     * @return string 
     */
    public function getRightsString(){
        $rightsList = $this->getRightsArray();
        $rightStrings = "";
        foreach($rightsList as $rights){
            $open = isset($rights['open'])?"open:true,":'';
            $check = isset($rights['defaultCheck']) && $rights['defaultCheck']?"checked:true,":'';
            $rightStrings .= "{ id:{$rights['id']}, pId:{$rights['pId']}, name:'".$rights['name']."',"
                    .$open
                    .$check
                    ."},";
        }
        //echo $rightStrings;exit;
        return $rightStrings;
    }
    
    /**
     * 获取已有权限树字串
     * @return string 
     */
    public function getExistRightsString(){
        $rightsList = $this->getRightsArray();
        $auth = Yii::$app->authManager;

        $permissonList = $auth->getPermissionsByRole($this->name);//已有权限
        $rightStrings = "";
        foreach($rightsList as $rights){
            $open = isset($rights['open'])?"open:true,":'';
            $check = array_key_exists($rights['name'], $permissonList)?"checked:true,":'';
            $rightStrings .= "{ id:{$rights['id']}, pId:{$rights['pId']}, name:'".$rights['name']."',"
                    .$open
                    .$check
                    ."},";
        }
        //echo $rightStrings;exit;
        return $rightStrings;
    }    
    
    
    /**
     *权限初始化 
     */
    public function init(){
        $rightsList = $this->getRightsArray();
        
        $auth = Yii::$app->authManager;
        foreach($rightsList as $rights){
            $rightsName = $rights['name'];
            
            $rightsExist = $auth->getPermission($rightsName);
            if(!$rightsExist){
                $rightsPermission = $auth->createPermission($rightsName);
                $auth->add($rightsPermission);
            }
        }        
    }
    
    /**
     * 创建用户权限
     * @param string $rightsList 用户选中的权限ID字符串
     */
    public function createRights($rightsList){
        $rightsArray = $this->getRightsArray();
        $selectRights = explode("|", $rightsList);
        $auth = Yii::$app->authManager;
        
        foreach($selectRights as $rightID){
            $rightValue = $rightsArray[$rightID]['name'];
            $rightsPermission = $auth->getPermission($rightValue);
            $role             = $auth->getRole($this->name);
            $auth->addChild($role, $rightsPermission);
        }
    }
    
    /**
     * 更新角色权限
     * @param string $rightsList
     */
    public function updateRights($rightsList){
        $auth = Yii::$app->authManager;
        $role             = $auth->getRole($this->name);
        $auth->removeChildren($role);
        $this->createRights($rightsList);
    }
    
    /**
     * 获取角色数组
     * @param Manager 管理员
     * @return array 角色数组
     */
    public static function getRoleArray($manager){
         $roleList = self::findAll(['type'=>1]);
         $roleArray = array();
         if($manager->role != self::SUPER_MASTER){
            foreach($roleList as $role){
                   if($role->name == self::SUPER_MASTER)
                       continue;
                $roleArray[$role->name] = $role->name;
            }
         }else{

                $roleArray[$manager->role] = $manager->role;

         }
         return $roleArray;
    }
}
