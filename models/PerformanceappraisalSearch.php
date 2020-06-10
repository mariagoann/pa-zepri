<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Employment;

/**
 * PersonalinfoSearch represents the model behind the search form of `app\models\Personalinfo`.
 */
class PerformanceappraisalSearch extends Model
{
    /**
     * {@inheritdoc}
     */
    public $field="";
    public function rules()
    {
        return [
            [['field'], 'safe'],
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
    public function search($field)
    {
        $query = Employment::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('personal');
        $query->andFilterWhere(['like', 'personalinfo.FullName',$field]);
        return $dataProvider;
    }
}
