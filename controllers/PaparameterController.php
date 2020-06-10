<?php

namespace app\controllers;

use Yii;
use app\models\Paparameter;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Performanceappraisal;
use app\models\Personalinfo;
use app\models\Employment;
use app\models\Pacomponent;

/**
 * PaparameterController implements the CRUD actions for Paparameter model.
 */
class PaparameterController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Paparameter models.
     * @return mixed
     */
    public function actionIndex(){
        $peers=null;
        $subordinate = null;
        $superior = null;
        $employee = null;
        $personalinfo = Personalinfo::find()
                                ->where(['UserID'=>Yii::$app->user->id])
                                ->one();
        if($personalinfo!=null){
            $employee = Performanceappraisal::find()
                        ->joinWith('periode')
                        ->where(['performanceappraisal.EmployeeID'=>$personalinfo->employments->EmployeeID])
                        ->andWhere(['periode.status'=>1])
                        ->one();
            
            if($employee!=null){
            $peers = Performanceappraisal::find()
                            ->joinWith('periode')
                            ->where(['performanceappraisal.PeersID1'=>$personalinfo->employments->EmployeeID])
                            ->orWhere(['performanceappraisal.PeersID2'=>$personalinfo->employments->EmployeeID])
                            ->andWhere(['periode.status'=>1])
                            ->all();

            $superior = Performanceappraisal::find()
                            ->joinWith('periode')
                            ->where(['performanceappraisal.SuperiorID1'=>$personalinfo->employments->EmployeeID])
                            ->andWhere(['periode.status'=>1])
                            ->all();
            //check for superior2
            $subordinate = Performanceappraisal::find()
                            ->joinWith('periode')
                            ->where(['performanceappraisal.SubordinateID1'=>$personalinfo->employments->EmployeeID])
                            ->orWhere(['performanceappraisal.SubordinateID2'=>$personalinfo->employments->EmployeeID])
                            ->andWhere(['periode.status'=>1])
                            ->all();
            }
        }

        return $this->render('index', [
            'employee'=>$employee,
            'peers'=>$peers,
            'superior'=>$superior,
            'subordinate'=>$subordinate
        ]);
    }

    /**
     * Displays a single Paparameter model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Paparameter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * {employeeid by} {performance appraisal id} {type}
     */
    public function actionNilai($by,$id,$type)
    {   
        $value = [
            1=>'1',
            2=>'2',
            3=>'3',
            4=>'4',
            5=>'5'
        ];
        $judul = $this->mapType($type);
        $prfmaprsl = Performanceappraisal::find()
                                    ->where(['PerformanceAppraisalID'=>$id])
                                    ->one();
        $employee = Employment::find()
                                ->where(['EmployeeID'=>$prfmaprsl->EmployeeID])
                                ->one();
        $model = new Paparameter();
        if ($model->load(Yii::$app->request->post())) {
            //save paparameter
            $post = Yii::$app->request->post();
            $performancescore = int($post['Paparameter']['EmployeePerformanceScore']);
            $agile = int($post['Paparameter']['AGILE']);
            $impact = int($post['Paparameter']['IMPACT']);
            $udpe = int($post['Paparameter']['UDPE']);
            $entrepreneurial = int($post['Paparameter']['Entrepreneurial']);
            $innovation = int($post['Paparameter']['OpenInnovation']);
            $model->total = $performancescore + $agile + $impact + $udpe
                                + $entrepreneurial + $innovation;
            $model->PerformanceAppraisalID = $id;
            $model->ReviewByID = $by;
            $model->save();
            //doCalculation
            $calculate = $this->doCalculation($id, $prfmaprsl->EmployeeID, $prfmaprsl->PeriodeID, $type);
            return $this->redirect(['view', 'id' => $model->PAParameterID]);
        }
        return $this->render('create', [
            'judul'=>$judul,
            'model' => $model,
            'prfmaprsl'=>$prfmaprsl,
            'employee'=>$employee,
            'value'=>$value,
        ]);
    }

    /**
     * {performanceappraisal id, employee id, periode id, type}
     */
    private function doCalculation($idpa, $idemployee, $idperiode, $type){
        $model = Pacomponent::find()
                            ->where(['PerformanceAppraisalID'=>$idpa])
                            ->andWhere(['EmployeeID'=>$idemployee])
                            ->andWhere(['PeriodeID'=>$idperiode])
                            ->one();
        if($model==null){
            $model = new Pacomponent();
        }
        $type = explode('-',$type);
    }

    private function mapType($type){
        $type = explode('-', $type);
        $arrType = [
            'self'=>'Self Performance Appraisal',
            'peers'=>'Peers Performance Appraisal',
            'superior'=>'Superior to Subordinate Appraisal',
            'subordinate'=>'Subordinate to Superior Appraisal'
        ];
        if(count($type)>1){
            return $arrType[$type[0]]." - ".$type[1];
        }
        return $arrType[$type[0]];
    }

    /**
     * Updates an existing Paparameter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->PAParameterID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Paparameter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Paparameter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paparameter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Paparameter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
