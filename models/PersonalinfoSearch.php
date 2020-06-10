<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Personalinfo;

/**
 * PersonalinfoSearch represents the model behind the search form of `app\models\Personalinfo`.
 */
class PersonalinfoSearch extends Model
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
        $query = Personalinfo::find();
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

        $query->orFilterWhere(['like', 'FullName', $field])
            ->orFilterWhere(['like', 'IdentityNumber', $field])
            ->orFilterWhere(['like', 'Address', $field])
            ->orFilterWhere(['like', 'Email', $field]);
        return $dataProvider;
    }
}
