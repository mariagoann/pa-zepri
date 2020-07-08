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
use app\models\Paparemeter;
use app\models\PeriodeSearch;
use app\models\Periode;
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
    public function actionIndex($id){
        $_tempEmployee=null;
        $_tempPeers = null;
        $_tempSuperior = null;
        $_tempSubordinate = null;
        $personalinfo = Personalinfo::find()
                                ->where(['UserID'=>Yii::$app->user->id])
                                ->one();
        $periode = Periode::find()
                            ->where(['PeriodeID'=>$id])
                            ->one();
        if($personalinfo!=null){
            $by = $personalinfo->employments->EmployeeID;
            $employee = Performanceappraisal::find()
                        ->joinWith('periode')
                        ->where(['performanceappraisal.EmployeeID'=>$personalinfo->employments->EmployeeID])
                        ->andWhere(['periode.status'=>1])
                        ->andWhere(['performanceappraisal.PeriodeID'=>$id])
                        ->andWhere(['performanceappraisal.Status'=>'1'])
                        ->one();
            if($employee!=null){
                $_tempEmployee['name'] = $employee->employee->personal->FullName;
                $_tempEmployee['by'] = $by;
                $_tempEmployee['id'] = $employee->PerformanceAppraisalID;
                $_tempEmployee['type'] = 'self';
                $_tempEmployee['status'] = $this->isEvaluate($employee->PerformanceAppraisalID, $employee->EmployeeID, 'self');
            }
            $peers = Performanceappraisal::find()
                    ->joinWith('periode')
                    ->where(['performanceappraisal.PeersID1'=>$personalinfo->employments->EmployeeID])
                    ->orWhere(['performanceappraisal.PeersID2'=>$personalinfo->employments->EmployeeID])
                    ->andWhere(['periode.status'=>1])
                    ->andWhere(['performanceappraisal.PeriodeID'=>$id])
                    ->andWhere(['performanceappraisal.Status'=>'1'])
                    ->all();
            if($peers!=null){
                $i=1;
                foreach ($peers as $key => $value) {
                    $_tempPeers[$i]['name'] = $value->employee->personal->FullName;
                    $_tempPeers[$i]['by'] = $by;
                    $_tempPeers[$i]['id'] = $value->PerformanceAppraisalID;
                    $_tempPeers[$i]['type'] = 'peers-'.$i;
                    $_tempPeers[$i]['status'] = $this->isEvaluate($value->PerformanceAppraisalID, $by, 'peers-'.$i);
                    $i++;
                }
            }
            $superior = Performanceappraisal::find()
                            ->joinWith('periode')
                            ->where(['performanceappraisal.SuperiorID1'=>$personalinfo->employments->EmployeeID])
                            ->orWhere(['performanceappraisal.SuperiorID2'=>$personalinfo->employments->EmployeeID])//or superior2
                            ->andWhere(['periode.status'=>1])
                            ->andWhere(['performanceappraisal.PeriodeID'=>$id])
                            ->andWhere(['performanceappraisal.Status'=>'1'])
                            ->all();
            if($superior!=null){
                $i=1;
                foreach ($superior as $key => $value) {
                    $_tempSuperior[$i]['name'] = $value->employee->personal->FullName;
                    $_tempSuperior[$i]['by'] = $by;
                    $_tempSuperior[$i]['id'] = $value->PerformanceAppraisalID;
                    $_tempSuperior[$i]['type'] = 'superior-'.$i;
                    $_tempSuperior[$i]['status'] = $this->isEvaluate($value->PerformanceAppraisalID, $by, 'superior-'.$i);
                    $i++;
                }
            }
    
            $subordinate = Performanceappraisal::find()
                            ->joinWith('periode')
                            ->where(['performanceappraisal.SubordinateID1'=>$personalinfo->employments->EmployeeID])
                            ->orWhere(['performanceappraisal.SubordinateID2'=>$personalinfo->employments->EmployeeID])
                            ->andWhere(['periode.status'=>1])
                            ->andWhere(['performanceappraisal.PeriodeID'=>$id])
                            ->andWhere(['performanceappraisal.Status'=>'1'])
                            ->all();
            if($subordinate!=null){
                $i=1;
                foreach ($subordinate as $key => $value) {
                    $_tempSubordinate[$i]['name'] = $value->employee->personal->FullName;
                    $_tempSubordinate[$i]['by'] = $by;
                    $_tempSubordinate[$i]['id'] = $value->PerformanceAppraisalID;
                    $_tempSubordinate[$i]['type'] = 'subordinate-'.$i;
                    $_tempSubordinate[$i]['status'] = $this->isEvaluate($value->PerformanceAppraisalID, $by, 'subordinate-'.$i);
                    $i++;
                }
            }
        }
        // echo "<pre>";
        // print_r($_tempEmployee);
        // print_r($_tempPeers);
        // print_r($_tempSubordinate);
        // print_r($_tempSuperior);
        // die;
        return $this->render('index', [
            'employee'=>$_tempEmployee,
            'peers'=>$_tempPeers,
            'superior'=>$_tempSuperior,
            'subordinate'=>$_tempSubordinate,
            'periode'=>$periode,
        ]);
    }

    public function actionEvaluates(){
        $searchModel = new PeriodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('evaluates', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * {performance appraisal id} {id reviewer} {type}
     */
    private function isEvaluate($idpa,$idreviewer,$type){
        $_check = Paparameter::find()
                            ->where(['PerformanceAppraisalID'=>$idpa])
                            ->andWhere(['TypePA'=>$type])
                            ->andWhere(['ReviewByID'=>$idreviewer])
                            ->one();
        if($_check!=null){
            return true;
        }
        return false;
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
    public function actionNilai($by,$id,$type){   
        $judul = $this->mapType($type);
        $prfmaprsl = Performanceappraisal::find()
                                    ->where(['PerformanceAppraisalID'=>$id])
                                    ->one();
        //check kedaluarsa
        if(date('Y-m-d')>$prfmaprsl->periode->LastModified){
            if(!Yii::$app->session->has('outofdate')){
                Yii::$app->session->setFlash('outofdate', "Batas penilaian telah berakhir!", null);
                return $this->redirect(['evaluates']);
            }
        }
        $employee = Employment::find()
                                ->where(['EmployeeID'=>$prfmaprsl->EmployeeID])
                                ->one();
        $model = new Paparameter();
        if ($model->load(Yii::$app->request->post())) {
            //save paparameter
            $post = Yii::$app->request->post();
            $agile = floatval($post['Paparameter']['AGILE']);
            $impact = floatval($post['Paparameter']['IMPACT']);
            $udpe = floatval($post['Paparameter']['UDPE']);
            $entrepreneurial = floatval($post['Paparameter']['Entrepreneurial']);
            $innovation = floatval($post['Paparameter']['OpenInnovation']);
            $total = $agile + $impact + $udpe
                                + $entrepreneurial + $innovation;
            $average = floatval($total/5);
            $model->AvgValues = $average;
            $model->TypePA = $type;
            $model->PerformanceAppraisalID = $id;
            $model->ReviewByID = $by;
            $model->Status=1;
            $model->save(false);
            //doCalculation
            $calculate = $this->doCalculation($id);
            if($calculate){
                if(!Yii::$app->session->has('successnilai')){
                    Yii::$app->session->setFlash('successnilai', "Anda berhasil melakukan penilaian. Terima Kasih.",null);
                }
            }else{
                if(!Yii::$app->session->has('error')){
                    Yii::$app->session->setFlash('error', "Terdapat Kesalahan.",null);
                }
            }
            return $this->redirect(['index','id'=>$prfmaprsl->PeriodeID]);
        }
        return $this->render('create', [
            'judul'=>$judul,
            'model' => $model,
            'prfmaprsl'=>$prfmaprsl,
            'employee'=>$employee,
        ]);
    }

    public function actionUbahnilai($by,$id,$type){   
        $judul = $this->mapType($type);
        $prfmaprsl = Performanceappraisal::find()
                                    ->where(['PerformanceAppraisalID'=>$id])
                                    ->one();
        if(date('Y-m-d')>$prfmaprsl->periode->LastModified){
            if(!Yii::$app->session->has('outofdate')){
                Yii::$app->session->setFlash('outofdate', "Batas penilaian telah berakhir!");
            }
            return $this->redirect(['evaluates']);
        }
        $employee = Employment::find()
                                ->where(['EmployeeID'=>$prfmaprsl->EmployeeID])
                                ->one();
        $model = Paparameter::find()
                                ->where(['TypePA'=>$type])
                                ->andWhere(['PerformanceAppraisalID'=>$id])
                                ->andWhere(['ReviewByID'=>$by])
                                ->one();
        if ($model->load(Yii::$app->request->post())) {
            //save paparameter
            $post = Yii::$app->request->post();
            $agile = floatval($post['Paparameter']['AGILE']);
            $impact = floatval($post['Paparameter']['IMPACT']);
            $udpe = floatval($post['Paparameter']['UDPE']);
            $entrepreneurial = floatval($post['Paparameter']['Entrepreneurial']);
            $innovation = floatval($post['Paparameter']['OpenInnovation']);
            $total = $agile + $impact + $udpe
                                + $entrepreneurial + $innovation;
            $average = floatval($total/5);
            $model->AvgValues = $average;
            $model->TypePA = $type;
            $model->PerformanceAppraisalID = $id;
            $model->ReviewByID = $by;
            $model->Status = 1;
            $model->save(false);
            //doCalculation
            $calculate = $this->doCalculation($id);
            if($calculate){
                if(!Yii::$app->session->has('successedit')){
                    Yii::$app->session->setFlash('successedit', "Anda berhasil melakukan perubahan penilaian. Terima Kasih.");
                }
            }else{
                if(!Yii::$app->session->has('error')){
                    Yii::$app->session->setFlash('error', "Terdapat Kesalahan.");
                }
            }
            return $this->redirect(['index','id'=>$prfmaprsl->PeriodeID]);
        }
        return $this->render('update', [
            'judul'=>$judul,
            'model' => $model,
            'prfmaprsl'=>$prfmaprsl,
            'employee'=>$employee,
        ]);
    }

    public function actionSave(){

    }

    /**
     * {performanceappraisal id, employee id}
     */
    private function doCalculation($idpa){
        //get all pa
        $_allpa = Paparameter::find()
                                ->where(['PerformanceAppraisalID'=>$idpa])
                                ->all();
        $_pa = Performanceappraisal::find()
                                ->where(['PerformanceAppraisalID'=>$idpa])
                                ->one();
        $_positionReviwee = $_pa->employee->jobPosition->JobPositionName;
        if($_allpa!=null){
            $_temp=[];
            $i=0; $j=0; $k=0; $l=0;
            foreach ($_allpa as $key => $value) {
                if(strpos($value->TypePA, 'self')!==false){
                    $_avgValues = floatval((10/100 * $value->AvgValues));
                    $_temp['self'][$i] = [
                        'performancescore'=>$value->EmployeePerformanceScore,
                        'avg'=>$_avgValues,
                    ];
                    $i++;
                }elseif(strpos($value->TypePA, 'superior')!==false){
                    $_countSubs = $this->countSubsOnPeriode($value->performanceAppraisal->EmployeeID);
                    $_avgValues = 0;
                    if(strtolower($_positionReviwee)=='head' || $_countSubs==0){
                        $_avgValues = floatval((75/100 * $value->AvgValues));
                    }else{
                        $_avgValues = floatval((60/100 * $value->AvgValues));
                    }
                    $_temp['superior'][$j]=  [
                        'performancescore'=>$value->EmployeePerformanceScore,
                        'avg'=>$_avgValues,
                    ];
                    $j++;
                }elseif(strpos($value->TypePA, 'subordinate')!==false){
                    $_avgValues = floatval((15/100 * $value->AvgValues));
                    $_temp['subordinate'][$k]=[
                        'performancescore'=>$value->EmployeePerformanceScore,
                        'avg'=>$_avgValues,
                    ];
                    $k++;
                }elseif(strpos($value->TypePA, 'peers')!==false){
                    $_avgValues = floatval((15/100 * $value->AvgValues));
                    $_temp['peers'][$l]=  [
                        'performancescore'=>$value->EmployeePerformanceScore,
                        'avg'=>$_avgValues,
                    ];
                    $l++;
                }
            }
            $_selfAvg=0;
            $_superiorAvg=0;
            $_peersAvg= 0;
            $_subordinateAvg = 0;
            $_performanceFrSelf = 0;
            $_performanceFrSuperior = 0;
            if(array_key_exists('self',$_temp)){
                $_total = 0;
                $i=0;
                $_positionReviewer ="";
                foreach ($_temp['self'] as $key => $value) {
                    $_performanceFrSelf += $value['performancescore'];
                    $_total += $value['avg'];
                    $i++;
                }
                $_selfAvg = floatval($_total/$i);
            }
            if(array_key_exists('superior',$_temp)){
                $_total = 0;
                $i=0;
                $_totalPrf=0;
                foreach ($_temp['superior'] as $key => $value) {
                    $_totalPrf += $value['performancescore'];
                    $_total += $value['avg'];
                    $i++;
                }
                $_superiorAvg = floatval($_total/$i);
                $_performanceFrSuperior = floatval($_totalPrf/$i);
            }
            if(array_key_exists('peers',$_temp)){
                $_total = 0;
                $i=0;
                foreach ($_temp['peers'] as $key => $value) {
                    $_total += $value['avg'];
                    $i++;
                }
                $_peersAvg = floatval($_total/$i);
            }
            if(array_key_exists('subordinate',$_temp)){
                $_total = 0;
                $i=0;
                foreach ($_temp['subordinate'] as $key => $value) {
                    $_total += $value['avg'];
                    $i++;
                }
                $_subordinateAvg = floatval($_total/$i);
            }
            $_totalSelfAvg = floatval(((20/100)*$_performanceFrSelf) + ((80/100)*$_performanceFrSuperior));
            $_totalValues = floatval($_selfAvg + $_superiorAvg + $_subordinateAvg + $_peersAvg);
            $_result = floatval(((80/100)*$_totalSelfAvg) + ((20/100)*$_totalValues));
            
            //save pacomponent
            $modelPAC = Pacomponent::find()
                                ->where(['PerformanceAppraisalID'=>$idpa])
                                ->one();
            if($modelPAC==null){
                $modelPAC = new Pacomponent();
            }
            $modelPAC->PerformanceAppraisalID = $idpa;
            $modelPAC->Self = $_selfAvg;
            $modelPAC->Peers = $_peersAvg;
            $modelPAC->SubordinatesToSuperior = $_subordinateAvg;
            $modelPAC->SuperiorToSubordinates = $_superiorAvg;
            $modelPAC->EmployeeScore  = $_totalSelfAvg;
            $modelPAC->EmployeeID = $_pa->employee->EmployeeID;
            $modelPAC->PeriodeID = $_pa->PeriodeID;
            $modelPAC->TotalScore =$_result;
            $modelPAC->save(false);
            return true;
        }
        return false;
    }

    /**
     * cek karyawan tidak memiliki bawahan penilai pada periode berjalan
     */
    private function countSubsOnPeriode($idpa){
        $all = Paparameter::find()
                            ->where(['PerformanceAppraisalID'=>$idpa])
                            ->andWhere(['like','TypePA','%subordinate%',false])
                            ->count();
        return $all;
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
