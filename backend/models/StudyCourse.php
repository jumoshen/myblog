<?php

namespace backend\models;

use Yii;
use backend\models\User;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use backend\models\CourseTagRelation;
use backend\models\Tag;
use yii\db\Query;

/**
 * This is the model class for table "study_course".
 *
 * @property string $course_id
 * @property string $course_title
 * @property string $course_intro
 * @property string $course_detail
 * @property integer $course_type
 * @property integer $created_at
 * @property integer $user_id
 * @property string $course_cover
 */
class StudyCourse extends \yii\db\ActiveRecord
{

    /**
    * 课程类型PHP
    */
    const TYPE_OF_PHP = 0;

    /**
    * 课程类型MYSQL
    */
    const TYPE_OF_MYSQL = 1;

    /**
    * 课程类型LINUX
    */
    const TYPE_OF_LINUX = 2;

    /**
    * 课程类型DIV&CSS&JS
    */
    const TYPE_OF_DCJ = 3;

    /**
    * 课程类型其他
    */
    const TYPE_OF_OTHER = 4;

    const TYPE_OF_PYTHON = 5;

    const TYPE_OF_GOLANG = 6;

    const PAGE_SIZE = 5;

    public $tags;

    public $defaultCover = 'uploads/course_cover/default/default.jpg';

    public $courseCover = array(
        self::TYPE_OF_PHP => 'uploads/course_cover/default/php.jpg',
        self::TYPE_OF_MYSQL => 'uploads/course_cover/default/mysql.jpg',
        self::TYPE_OF_LINUX => 'uploads/course_cover/default/centos.jpg',
        self::TYPE_OF_DCJ => 'uploads/course_cover/default/html.jpg',
        self::TYPE_OF_OTHER => 'uploads/course_cover/default/default.jpg'
    );

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'study_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_title', 'course_intro', 'course_detail', 'course_type', 'created_at'], 'required'],
            [['course_type', 'created_at', 'user_id'], 'integer'],
            [['course_title', 'course_intro'], 'string', 'max' => 255],
            [['course_detail', 'course_cover'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'course_id' => '教程 ID',
            'course_title' => '教程标题',
	    'course_cover' => '课程封面',
            'course_intro' => '教程简介',
            'course_detail' => '教程详情',
            'course_type' => '教程类型',
            'created_at' => '创建时间',
            'user_id' => '用户',
            'tags' => '标签',
        ];
    }

     /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCover(){
        return $this->course_cover ? "<div class='image-review'><img src=/$this->course_cover width='100' height='100'/></div>" : '<span style="color:lightgrey">暂无</span>';
    }


    /**
    * get all users
    * @return array
    */
    public static function getUsers(){
        $userModel = new User();
        $users = $userModel->find()->select(['id', 'username'])->asArray()->all();
        $usersArray = array('' => '请选择');
        foreach ($users as $key => $user) {
            $usersArray[$users[$key]['id']] = $users[$key]['username'];
        }
        return $usersArray;

    }


    /**
    * get all course type
    * @param bool $isReal
    * @return array
    **/
    public static function allCourseType($isReal = false){
        $courseTypes = array(
            ''                => '请选择',
            self::TYPE_OF_PHP   => 'PHP',
            self::TYPE_OF_MYSQL => 'MYSQL',
            self::TYPE_OF_LINUX => 'LINUX',
            self::TYPE_OF_DCJ   => 'DIV&CSS&JS',
            self::TYPE_OF_PYTHON => 'PYTHON',
            self::TYPE_OF_GOLANG => 'GOLANG',
            self::TYPE_OF_OTHER => '其他'
        );
	if($isReal) unset($courseTypes['']);
        return $courseTypes;
    }


    /**
    * @return string courseType
    **/
    public function getType(){
        $courseTypes = self::allCourseType();
        return $courseTypes[$this->course_type];
    }

    public static function getStaticType($courseType){
        $courseTypes = self::allCourseType();
        return $courseTypes[$courseType];
    }

    /**
     * 获取首页输出内容
     * @param   $courseType int 教程类型
     * @param   $limit      int 搜索条数
     * @return  array           教程搜索结果 
    **/
    public static function getCourseList_bak($courseType = null, $limit = 5){//已废弃

        $query = Message::find()->where(['is_delete'=>0]);
        $count = Message::find()->where(['is_delete'=>0])->count();     //获取数据条数
        $pages = new Pagination(['totalCount' =>$count,'pageSize'=>5]);

        $res = $query->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();

        if (empty($courseType)) {
            $courseList = self::find()->limit($limit)->all();
        }else{
            $courseList = self::find()->where(['course_type' => $courseType])->limit($limit)->all();
        }
        foreach ($courseList as $key => $course) {
            $courseList[$key]['course_type'] = self::getStaticType($course['course_type']);
            $courseList[$key]['user_id']     = User::findByUserId($course['user_id'])->username;
        }
        return $courseList;
        
    }

    /**
     * 获取首页输出内容
     * @param   $courseType int 教程类型
     * @param   $pageSize   int 每页条数
     * @param   $tagId      int
     * @return  array           教程搜索结果 
    **/
    public static function getCourseList($courseType = null, $pageSize = self::PAGE_SIZE, $tagId = null){
        
        $courseLists = array();    

        $query = self::find()
                ->orderBy('created_at DESC');

        if (!empty($courseType)) {
            $query->andFilterWhere(['course_type' => $courseType]);
        }

        if(!empty($tagId)){
            $query->leftJoin(CourseTagRelation::tableName(), CourseTagRelation::tableName().'.'.'course_id = '.self::tableName().'.'.'course_id');
            $query->andFilterWhere(['tag_id' => $tagId]);
        }

        $count = $query->count();

        $pagination = new Pagination([
            'totalCount' =>$count, 'pageSize'=> $pageSize
        ]);

        $courseList = $query
                    ->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();

        foreach ($courseList as $key => $course) {

            $courseList[$key]['course_type'] = self::getStaticType($course['course_type']);
            $courseList[$key]['user_id']     = User::findByUserId($course['user_id'])->username;
            $courseList[$key]['tags']        = self::findTags($courseList[$key]['course_id']);

        }

        $courseLists['pagination'] = LinkPager::widget(['pagination' => $pagination]);
        $courseLists['data']       = $courseList;

        return $courseLists;
        
    }

    /**
     * 打开页面时自动加一
     * @return boolean  
    **/
    public static function increaseViews($id){
        $result = false;
        $data = self::findOne($id);
        $data->views += 1;
        if($data->save()){
            $result = true;
        }
        return $result;
    }

    /**
     * 保存标签教程关系
     * @param $course_id int
     * @return bool
     * @throws
     **/
    public function addTags($course_id){
        $tagModel = new Tag();
        $tagModel->tag_name = $this->tags;
        $tagIdArray = $tagModel->saveTag();
        CourseTagRelation::deleteAll('course_id=:course_id', [':course_id' => $course_id]);
        //批量保存文章和标签的多对多关系
        if (!empty($tagIdArray)) {
            foreach ($tagIdArray as $key => $id) {
                $row[$key]['tag_id'] = $id;
                $row[$key]['course_id'] = $course_id;
            }
            $res = (new Query())->createCommand()
                                ->batchInsert(CourseTagRelation::tableName(), ['tag_id', 'course_id'], $row)
                                ->execute();
            if (!$res) {
                throw new \Exception('标签教程关系保存失败');
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * @param $id int
     * @return array
     **/
    public static function findTags($id){
        $tagModel = new Tag();
        $relates = CourseTagRelation::findAll(['course_id' => $id]);
        $tagIdArray = array();
        foreach($relates as $key => $relate){
            $tmpTag = $tagModel->findModel($relates[$key]['tag_id']);
            $tagIdArray[] = $tmpTag['tag_name'];
        }
        return $tagIdArray;
    }

}
