<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\StudyCourse;

/**
 * StudyCourseSearch represents the model behind the search form about `backend\models\StudyCourse`.
 */
class StudyCourseSearch extends StudyCourse
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id', 'course_type', 'created_at', 'user_id'], 'integer'],
            [['course_title', 'course_intro', 'course_detail'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = StudyCourse::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'course_id' => $this->course_id,
            'course_type' => $this->course_type,
            'created_at' => $this->created_at,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'course_title', $this->course_title])
            ->andFilterWhere(['like', 'course_intro', $this->course_intro])
            ->andFilterWhere(['like', 'course_detail', $this->course_detail]);

        return $dataProvider;
    }
}
