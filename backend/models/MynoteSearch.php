<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Mynote;

/**
 * MynoteSearch represents the model behind the search form about `backend\models\Mynote`.
 */
class MynoteSearch extends Mynote
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'link', 'author'], 'safe'],
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
        $query = Mynote::find()->orderBy('create_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if(!empty($params["MynoteSearch"]["create_at"])){
            $query->andFilterWhere(['>=' , $this->tableName().'.create_at' , strtotime($params["MynoteSearch"]["create_at"])]);
            $query->andFilterWhere(['<=' , $this->tableName().'.create_at' , strtotime($params["MynoteSearch"]["create_at"]) + 86400]);
            $this->create_at = $params["MynoteSearch"]["create_at"];
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'author', $this->author]);


        return $dataProvider;
    }
}
