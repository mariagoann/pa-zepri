<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pacomponent;
use app\models\Employment;

/**
 * PersonalinfoSearch represents the model behind the search form of `app\models\Personalinfo`.
 */
class PacomponentSearch extends Model
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
        $idpa = 0;
        if(isset($_GET['id'])){
            $idpa = $_GET['id'];
        }

        $query = Pacomponent::find()
                            ->innerJoin('employment', 'pacomponent.EmployeeID=employment.EmployeeID')
                            ->innerJoin('personalinfo', 'personalinfo.PersonalID=employment.PersonalID');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->orFilterWhere(['like', 'personalinfo.FullName', $field])
            ->orFilterWhere(['like', 'personalinfo.IdentityNumber', $field])
            ->orFilterWhere(['like', 'personalinfo.Address', $field])
            ->orFilterWhere(['like', 'personalinfo.Email', $field]);
        $query->andFilterWhere(['pacomponent.PeriodeID'=>$idpa]);
        return $dataProvider;
    }
}
