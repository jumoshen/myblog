<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Blogroll;

/**
 * BlogrollSearch represents the model behind the search form about `backend\models\Blogroll`.
 */
class BlogrollSearch extends Blogroll
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_checked'], 'integer'],
            [['web_name', 'link', 'web_logo_link', 'qq', 'email', 'remark', 'apply_time', 'pass_time'], 'safe'],
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
        $query = Blogroll::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_checked' => $this->is_checked,
        ]);

        $query->andFilterWhere(['like', 'web_name', $this->web_name])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'web_logo_link', $this->web_logo_link])
            ->andFilterWhere(['like', 'qq', $this->qq])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'apply_time', $this->apply_time])
            ->andFilterWhere(['like', 'pass_time', $this->pass_time]);

        return $dataProvider;
    }
}
