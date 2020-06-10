<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Periode;

/**
 * PeriodeSearch represents the model behind the search form of `app\models\Periode`.
 */
class PeriodeSearch extends Periode
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['PeriodeID'], 'integer'],
            [['Start', 'End', 'LastModified', 'Status'], 'safe'],
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
        $query = Periode::find();

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
            'PeriodeID' => $this->PeriodeID,
            'Start' => $this->Start,
            'End' => $this->End,
            'LastModified' => $this->LastModified,
        ]);

        $query->andFilterWhere(['like', 'Status', $this->Status]);

        return $dataProvider;
    }
}
