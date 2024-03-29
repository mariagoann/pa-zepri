<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Jobtitle;

/**
 * JobtitleSearch represents the model behind the search form of `app\models\Jobtitle`.
 */
class JobtitleSearch extends Jobtitle
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['JobTitleID'], 'integer'],
            [['CodeJobTitle', 'JobTitleName'], 'safe'],
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
        $query = Jobtitle::find();

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
            'JobTitleID' => $this->JobTitleID,
        ]);

        $query->andFilterWhere(['like', 'CodeJobTitle', $this->CodeJobTitle])
            ->andFilterWhere(['like', 'JobTitleName', $this->JobTitleName]);
        $query->orderBy(['CodeJobTitle'=>SORT_ASC]);
        return $dataProvider;
    }
}
