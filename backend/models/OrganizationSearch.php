<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Organization;

/**
 * OrganizationSearch represents the model behind the search form about `backend\models\Organization`.
 */
class OrganizationSearch extends Organization
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_id', 'parent_id'], 'integer'],
            [['org_name', 'parent_path', 'org_pass'], 'safe'],
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
        $query = Organization::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        
        $parentPath = \backend\models\Organization::getManagerBranchPath();
        $query->andFilterWhere(['like','parent_path',$parentPath]);
        
        $query->andFilterWhere(['>', 'parent_id', 0]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'org_id' => $this->org_id,
        ]);



        return $dataProvider;
    }
}
