<?php

namespace backend\models;

use Yii;
use backend\models\CourseTagRelation;
use backend\models\Tag;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "tag".
 *
 * @property string $id
 * @property string $tag_name
 * @property string $article_num
 */
class Tag extends \yii\db\ActiveRecord
{
    public $limit = 20;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_name', 'article_num'], 'required'],
            [['article_num'], 'integer'],
            [['tag_name'], 'string', 'max' => 255],
            [['tag_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_name' => 'Tag Name',
            'article_num' => 'Article Num',
        ];
    }



    /**
     * 批量保存标签
     **/
    public function saveTag()
    {
        $tagIdArray = [];
        if (!empty($this->tag_name)) {
            foreach($this->tag_name as $value){
                $tagIdArray[] = $this->_saveTag($value);
            }
        }

        return $tagIdArray;
    }

    /**
     * 保存标签
     * @param tagName
     * @return id
     * @throws $model->getErrors
     **/
    private function _saveTag($tagName)
    {
        $model = new Tag();
        $tags = $model->find()->where('tag_name=:tag_name',[':tag_name'=>$tagName])->one();
        if(!$tags){
            $model->tag_name = $tagName;
            $model->article_num = 1;
            if(!$model->save()){
                throw new \Exception(current($model->getErrors())[0]);
            }
            return $model->id;
        }else{
            $tags->updateCounters(['article_num' => 1]);
            return $tags->id;
        }
    }

    /**
     * findOne
     * @param $id int
     * @return array
     * @throws
     **/
    public function findModel($id){
        if (($model = self::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 获取首页标签
     * @return array tags
     **/
    public function getIndexTags(){
        $tags = $this->find()
                    ->orderBy(['article_num' => SORT_DESC])
                    ->limit($this->limit)
                    ->all();
        return empty($tags) ? [] : $tags;
    }

}