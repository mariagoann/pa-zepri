<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Squad;

/**
 * SquadSearch represents the model behind the search form of `app\models\Squad`.
 */
class SquadSearch extends Squad
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SquadID'], 'integer'],
            [['CodeSquad', 'SquadName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Squad::find();

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
            'SquadID' => $this->SquadID,
        ]);

        $query->andFilterWhere(['like', 'CodeSquad', $this->CodeSquad])
            ->andFilterWhere(['like', 'SquadName', $this->SquadName]);
        $query->orderBy(['CodeSquad'=>SORT_ASC]);
        return $dataProvider;
    }
}
