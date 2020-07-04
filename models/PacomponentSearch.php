<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pacomponent;
use app\models\Employment;
use app\models\Performanceappraisal;

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
        $eid = Yii::$app->session->get('employeeid');
        $isSuperior = Yii::$app->session->get('isSuperior');
        $role = Yii::$app->session->get('role');
        $query = Pacomponent::find()
                            ->innerJoin('employment', 'pacomponent.EmployeeID=employment.EmployeeID')
                            ->innerJoin('personalinfo', 'personalinfo.PersonalID=employment.PersonalID');
        if($isSuperior && $role!='admin'){
            $modelpa = Performanceappraisal::find()
                                        ->where(['EmployeeID'=>$eid])
                                        ->orWhere(['SuperiorID1'=>$eid])
                                        ->orWhere(['SuperiorID2'=>$eid])
                                        ->andWhere(['Status'=>'1'])
                                        ->all();
            $ids = [];
            if($modelpa!=null){
                foreach ($modelpa as $key => $value) {
                    array_push($ids,$value->PerformanceAppraisalID);
                }
            }
            $query = Pacomponent::find()
                                ->innerJoin('employment', 'pacomponent.EmployeeID=employment.EmployeeID')
                                ->innerJoin('personalinfo', 'personalinfo.PersonalID=employment.PersonalID')
                                ->where(['in','pacomponent.PerformanceAppraisalID',$ids]);
        }
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
        $query->orderBY(['personalinfo.FullName'=>SORT_ASC,
                        'pacomponent.PAComponentID'=>SORT_ASC]);
        return $dataProvider;
    }
}
