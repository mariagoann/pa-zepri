<?php

namespace app\controllers;

use Yii;
use app\models\Periode;
use app\models\PeriodeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Performanceappraisal;
use app\models\Employment;
use app\models\Pastatus;
use app\models\PacomponentSearch;
use app\models\Pacomponent;
use app\models\Paparameter;
use yii\helpers\Url;
use Mpdf\Mpdf;
use app\models\Notif;

/**
 * PeriodeController implements the CRUD actions for Periode model.
 */
class PeriodeController extends Controller
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
     * Lists all Periode models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PeriodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHasilPenilaian()
    {
        $searchModel = new PeriodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('hasilpenilaian', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Periode model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $_periode = $this->findModel($id);
        $pa = Performanceappraisal::find()
                        ->where(['PeriodeID'=>$id])
                        ->all();
        $status = false;
        if($pa!=null){
            foreach ($pa as $key => $value) {
                if($value->Status=='1'){
                    $status = true;
                    break;
                }
            }
        }
        return $this->render('view', [
            'model' => $pa,
            'periode'=>$_periode,
            'status'=>$status,
        ]);
    }

    public function actionKirim($id){
        $update = Performanceappraisal::updateAll(['Status' => '1'], ['=','PeriodeID', $id]);
        // $allpa = Performanceappraisal::find()->where(['PeriodeID'=>$id])->all();
        // if($allpa!=null){
        //     foreach ($allpa as $key=>$value) {
        //         $this->notif($value);
        //     }
        // }
        if($update){
            echo json_encode([
                'status'=>1,
                'message'=>"All data have been activated successfully.",
                'url'=>Url::to(['view','id'=>$id]),
            ]);
        }else{
            echo json_encode([
                'status'=>0,
                'message'=>'Something went wrong'
            ]);
        }
    }
    public function actionViewNilai($id, $field=null)
    {
        $searchModel = new PacomponentSearch();
        $searchModel->field = $field;
        $periode = $this->findModel($id);
        if ($searchModel->load(Yii::$app->request->post())){
            $_data = Yii::$app->request->post()['PacomponentSearch'];
            $searchModel->field = $_data['field'];
            $this->redirect(['view-nilai',
                            'id'=>$id,
                            'field'=>$searchModel->field]);
        }
        $dataProvider = $searchModel->search($field);
        return $this->render('viewnilai', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'periode'=>$periode,
        ]);
    }
    /**
     * Creates a new Periode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Periode();
        $active = [
            0=>'Non-Active',
            1=>'Active'
        ];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'active'=>$active,
        ]);
    }

    /**
     * Updates an existing Periode model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $active = [
            0=>'Non-Active',
            1=>'Active'
        ];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
            'active'=>$active,
        ]);
    }

    /**
     * Deletes an existing Periode model.
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

    public function actionGenerate($id){
        $_generate = $this->generate($id);
        return $this->render('generate',$_generate);
    }
    public function actionUpdateGenerate($id){
        $_generate = $this->generate($id);
        $_periode = $_generate['periode'];
        $_listsuperior = [
            0=>[
                'id'=>0,
                'name'=>'Pilih Atasan',
            ],
        ];
        $_superiors = $this->getSuperior($_periode->End);
        if($_superiors!=null){
            $i=1;
            foreach ($_superiors as $key => $value) {
                $_listsuperior[$i] =[
                    'id'=>$value->EmployeeID,
                    'name'=>$value->personal->FullName,
                ];
                $i++;
            }
        }
        $_generate['superiors'] = $_listsuperior;
        return $this->render('updategenerate',$_generate);
    }

    public function actionUpdateExisting($id){
        $_periode = $this->findModel($id);
        $_pas = Performanceappraisal::find()
                                    ->where(['PeriodeID'=>$id])
                                    ->all();
        $_listAll = $this->getAllKaryawan($_periode->End);
        $_listsuperior = [
            0=>[
                'id'=>0,
                'name'=>'Pilih Atasan',
            ],
        ];
        $_superiors = $this->getSuperior($_periode->End);
        if($_superiors!=null){
            $i=1;
            foreach ($_superiors as $key => $value) {
                $_listsuperior[$i] =[
                    'id'=>$value->EmployeeID,
                    'name'=>$value->personal->FullName,
                ];
                $i++;
            }
        }
        $_arr = [];
        if($_pas!=null){
            $i=0;
            foreach ($_pas as $key => $_value) {
                // $__peers = [
                //     0=>[
                //         'id'=>0,
                //         'name'=>'Pilih Peers'
                //     ],
                // ];
                // $__subordinate = [
                //     0=>[
                //         'id'=>0,
                //         'name'=>'Pilih Subordinate'
                //     ],
                // ];
                // $_squad = $this->getPeers($_periode->End,$_value->employee->SquadID, $_value->employee->JobPositionID, $_value->employee->OrganizationID, $_value->EmployeeID);
                // $_subordinate = $this->getSubordinate($_periode->End,$_value->EmployeeID);
                // if($_squad!=null){
                //     $j=1;
                //     foreach ($_squad as $key => $value) {
                //         $__peers[$j] = [
                //             'id'=>$value->EmployeeID,
                //             'name'=>$value->personal->FullName,
                //         ];
                //         $j++;
                //     }
                // }
                // if($_subordinate!=null){
                //     $j=1;
                //     foreach ($_subordinate as $key => $value) {
                //         $__subordinate[$j] = [
                //             'id'=>$value->EmployeeID,
                //             'name'=>$value->personal->FullName,
                //         ];
                //         $j++;
                //     }
                // }
                $_superior1name = '-';
                if($_value->employee->EmployeeSuperiorID!=null){
                    if($_value->employee->employeeSuperior->personal!=null){
                        $_superior1name = $_value->employee->employeeSuperior->personal->FullName;
                    }
                }
                $_arr[$i] = [
                    'paid'=>$_value->PerformanceAppraisalID,
                    'employeeid'=>$_value->EmployeeID,
                    'name'=>$_value->employee->personal->FullName,
                    'squad'=>$_value->employee->squad==null?'-':$_value->employee->squad->SquadName,
                    'jobposition'=>$_value->employee->jobPosition==null?'-':$_value->employee->jobPosition->JobPositionName,
                    'aliasJob'=>$_value->employee->AKA_JobPosition,
                    // 'peers'=>$__peers,
                    // 'subordinate'=>$__subordinate,
                    'superior1id'=>$_value->employee->EmployeeSuperiorID,
                    'superior1name'=>$_superior1name,
                    'vpeersid1'=>$_value->PeersID1,
                    'vpeersid2'=>$_value->PeersID2,
                    'vsuperiorid1'=>$_value->SuperiorID1,
                    'vsuperiorid2'=>$_value->SuperiorID2,
                    'vsubordinateid1'=>$_value->SubordinateID1,
                    'vsubordinateid2'=>$_value->SubordinateID2,
                ];
                $i++;
            } 
        }

        return $this->render('updateexisting',[
            'employee'=>$_pas,
            'periode'=>$_periode,
            'arr'=>$_arr,
            'superiors'=>$_listsuperior,
            'listAll'=>$_listAll
        ]);
    }

    private function generate($id){
        $_periode = $this->findModel($id);
        $_employee = Employment::find()
                                ->joinWith('personal')
                                ->joinWith('jobPosition')
                                ->where(['<=', 'employment.JoinDate', $_periode->End])
                                ->andWhere(['<>','AKA_JobPosition', 'CEO'])
                                ->orderBy([
                                    'jobposition.Level'=>SORT_ASC,
                                    'personalinfo.FullName'=>SORT_ASC,
                                ])
                                ->all();
        $_listAll = $this->getAllKaryawan($_periode->End);
        $_arr = [];
        if($_employee!=null){
            $i=0;
            foreach ($_employee as $key => $_value) {
               $__peers = null;
               $__subordinate = null;
               $vpeers1=null;
               $vpeers2=null;
               $vsubodinate1 = null;
               $vsubordinate2=null;
               $_squad = $this->getPeers($_periode->End,$_value->SquadID, $_value->JobPositionID, $_value->OrganizationID, $_value->EmployeeID);
               $_subordinate = $this->getSubordinate($_periode->End,$_value->EmployeeID);
               if($_squad!=null){
                 $j=0;
                 foreach ($_squad as $key => $value) {
                     $__peers[$j] = [
                         'id'=>$value->EmployeeID,
                         'name'=>$value->personal->FullName,
                     ];
                     $j++;
                 }
                 $vpeers1 = count($__peers)!=0?$__peers[0]['id']:null;
                 $vpeers2 = count($__peers)>1?$__peers[1]['id']:null;
               }
               if($_subordinate!=null){
                    $j=0;
                    foreach ($_subordinate as $key => $value) {
                        $__subordinate[$j] = [
                            'id'=>$value->EmployeeID,
                            'name'=>$value->personal->FullName,
                        ];
                        $j++;
                    }
                    $vsubodinate1 = count($__subordinate)!=0?$__subordinate[0]['id']:null;
                    $vsubordinate2 = count($__subordinate)>1?$__subordinate[1]['id']:null;
                }
                $_superior1name = '-';
                if($_value->EmployeeSuperiorID!=null){
                    if($_value->employeeSuperior->personal!=null){
                        $_superior1name = $_value->employeeSuperior->personal->FullName;
                    }
                }
               $_arr[$i] = [
                   'employeeid'=>$_value->EmployeeID,
                   'name'=>$_value->personal->FullName,
                   'squad'=>$_value->squad==null?'-':$_value->squad->SquadName,
                   'jobposition'=>$_value->jobPosition==null?'-':$_value->jobPosition->JobPositionName,
                   'aliasJob'=>$_value->AKA_JobPosition,
                   'peers'=>$__peers,
                   'subordinate'=>$__subordinate,
                   'superior1id'=>$_value->EmployeeSuperiorID,
                   'superior1name'=>$_superior1name,
                   'vpeers1'=>$vpeers1,
                   'vpeers2'=>$vpeers2,
                   'vsubordinate1'=>$vsubodinate1,
                   'vsubordinate2'=>$vsubordinate2,
               ];
               $i++;
            } 
        }
        return [
            'employee'=>$_employee,
            'periode'=>$_periode,
            'arr'=>$_arr,
            'listAll'=>$_listAll,
        ];
    }

    private function getPeers($end,$sqid,$jpid, $orid, $except){
        $_squad = Employment::find()
                            ->where(['SquadID'=>$sqid])
                            ->andWhere(['JobPositionID'=>$jpid])
                            ->andWhere(['<>','EmployeeID',$except])
                            ->andWhere(['<=', 'JoinDate', $end])
                            ->all();
        if($sqid==null){
            $_squad = Employment::find()
                        ->where(['OrganizationID'=>$orid])
                        ->andWhere(['JobPositionID'=>$jpid])
                        ->andWhere(['<>','EmployeeID',$except])
                        ->andWhere(['<=', 'JoinDate', $end])
                        ->all();
        }
        shuffle($_squad);
        return $_squad;
    }

    private function getSubordinate($end,$employeeid){
        $_subordinate = Employment::find()
                                ->where(['EmployeeSuperiorID'=>$employeeid])
                                ->andWhere(['<>','EmployeeID',$employeeid])
                                ->andWhere(['<=', 'JoinDate', $end])
                                ->all();
        shuffle($_subordinate);
        return $_subordinate;
    }

    private function getSuperior($end,$level=null){
        $atasan = Employment::find()
                            ->joinWith('jobPosition')
                            ->joinWith('personal')
                            ->andWhere(['<=', 'employment.JoinDate', $end])
                            ->andWhere(['<>','jobposition.Level','Staff']);
        if($level!=null){
            $atasan = $atasan->andWhere(['<','jobPosition.Level',$level]);
        }
        return $atasan->orderBy(['personalinfo.FullName'=>SORT_ASC,
                                'jobPosition.Level'=>SORT_ASC])
                        ->all();
    }

    private function getAllKaryawan($end){
        $all = Employment::find()
                        ->joinWith('jobPosition')
                        ->joinWith('personal')
                        ->where(['<=', 'employment.JoinDate', $end])
                        ->orderBy(['jobposition.Level'=>SORT_ASC,
                                'personalinfo.FullName'=>SORT_ASC])
                        ->all();
        $_listAll = null;
        if($all!=null){
            $i=1;
            foreach ($all as $key => $value) {
                $_listAll[$i] = [
                    'id'=>$value->EmployeeID,
                    'name'=>$value->personal->FullName,
                ];
                $i++;
            }
        }
        return $_listAll;
    }

    public function actionSave($id){
        if($_POST!=null){
            $_employee = $_POST['employeeid'];
            $_peers1 = $_POST['peersid1id'];
            $_peers2 = $_POST['peersid2id'];
            $_superior1 = $_POST['superiorid1'];
            $_superior2 = array_key_exists('superiorid2',$_POST)!==false?$_POST['superiorid2']:null;
            $_subordinate1 = $_POST['subordinate1id'];
            $_subordinate2 = $_POST['subordinate2id'];
            $_mode = $_POST['mode'];
            $_paid = array_key_exists('paid',$_POST)!==false?$_POST['paid']:null;
            for ($i=0; $i < count($_employee) ; $i++) { 
                $model = new Performanceappraisal();
                if($_paid!=null){
                    $model = Performanceappraisal::find()
                                                ->where(['PerformanceAppraisalID'=>$_paid[$i]])
                                                ->one();
                }
                $model->EmployeeID = $_employee[$i];
                $model->PeersID1 = $_peers1[$i]==0?null:$_peers1[$i];
                $model->PeersID2 = $_peers2[$i]==0?null:$_peers2[$i];
                $model->SuperiorID1 = $_superior1[$i]==0?null:$_superior1[$i];
                // $model->SuperiorID2 = $_superior2[$i]==0?null:$_superior2[$i];
                if(!isset($_superior2[$i]) || $_superior2[$i]==0){
                    $model->SuperiorID2 = null;
                }else{
                    $model->SuperiorID2=$_superior2[$i];
                }
                $model->SubordinateID1 = $_subordinate1[$i]==0?null:$_subordinate1[$i];
                $model->SubordinateID2 = $_subordinate2[$i]==0?null:$_subordinate2[$i];
                $model->PeriodeID = $id;
                $model->Status = $_mode;
                $model->save(false);

                // //send notif
                // if($_mode==1){
                //     $this->notif($model);
                // }
            }
            $message = 'Data Has been saved.';
            if($_mode==1){
                $message = 'Data has been saved and all status are activated.';
            }
            echo json_encode([
                'status'=>1,
                'message'=>$message,
                'url'=>Url::to(['view','id'=>$id]),
            ]);
        }else{
            echo json_encode([
                'status'=>0,
                'message'=>'Something went wrong.'
            ]);
        }
    }

    /**
     * {pacomponentid} {employeeid} {periodeid}
     */
    public function actionDetailNilai($id=null,$eid=null,$pid=null){
        $formed = $this->formeddetailnilai($id,$eid,$pid);
        if($formed!=null){
            return $this->render('detailnilai',$formed);
        }else{
            Yii::$app->session->setFlash('notevaluate', "Anda Belum melakukan evaluasi atau belum dievaluasi!");
            return $this->redirect(['hasil-penilaian']);
        }
    }

    private function formeddetailnilai($id=null,$eid=null,$pid=null){
        $_selfScore = [];
        $_superior1score = [];
        $_superior2score = [];
        $_valuesPeers1=[];
        $_valuesPeers2 = [];
        $_valuesSubordinate1=[];
        $_valuesSubordinate2=[];
        
        $modelPAC = Pacomponent::find()
                                ->where(['PAComponentID'=>$id])
                                ->one();
        if($id==null){
            $modelPAC = Pacomponent::find()
                            ->where(['EmployeeID'=>$eid])
                            ->andWhere(['PeriodeID'=>$pid])
                            ->one();
        }
        $flag = Yii::$app->session->get('employeeid')==$modelPAC->EmployeeID?true:false;
        if($modelPAC!=null){
            $paself = Paparameter::find()
                            ->where(['PerformanceAppraisalID'=>$modelPAC->PerformanceAppraisalID])
                            ->andWhere(['like','TypePA', '%self%',false])
                            ->one();
            $papeers = Paparameter::find()
                            ->where(['PerformanceAppraisalID'=>$modelPAC->PerformanceAppraisalID])
                            ->andWhere(['like','TypePA', '%peers%',false])
                            ->orderBy(['TypePA'=>SORT_ASC])
                            ->all();
            $pasuperior = Paparameter::find()
                            ->where(['PerformanceAppraisalID'=>$modelPAC->PerformanceAppraisalID])
                            ->andWhere(['like','TypePA', '%superior%',false])
                            ->orderBy(['TypePA'=>SORT_ASC])
                            ->all();
            $pasubordinate = Paparameter::find()
                            ->where(['PerformanceAppraisalID'=>$modelPAC->PerformanceAppraisalID])
                            ->andWhere(['like','TypePA', '%subordinate%',false])
                            ->orderBy(['TypePA'=>SORT_ASC])
                            ->all();
            if($paself!=null){
                $_selfScore = [
                    'by'=>$paself->reviewBy->personal->FullName,
                    'scoreEmployee'=>number_format($paself->EmployeePerformanceScore,2),
                    'avgValues'=>number_format($paself->AvgValues,2),
                ];
            }
            if($papeers!=null){
                $i=0;
                foreach ($papeers as $key => $value) {
                   if($i==0){
                        $_valuesPeers1 = [
                            'by'=>$value->reviewBy->personal->FullName,
                            'scoreEmployee'=>number_format($value->EmployeePerformanceScore,2),
                            'avgValues'=>number_format($value->AvgValues,2),
                        ];
                   }else{
                        $_valuesPeers2 = [
                            'by'=>$value->reviewBy->personal->FullName,
                            'scoreEmployee'=>number_format($value->EmployeePerformanceScore,2),
                            'avgValues'=>number_format($value->AvgValues,2),
                        ];
                   }
                   $i++;
                }
            }

            if($pasuperior!=null){
                $i=0;
                foreach ($pasuperior as $key => $value) {
                   if($i==0){
                        $_superior1score = [
                            'by'=>$value->reviewBy->personal->FullName,
                            'scoreEmployee'=>number_format($value->EmployeePerformanceScore,2),
                            'avgValues'=>number_format($value->AvgValues,2),
                        ];
                   }else{
                        $_superior2score = [
                            'by'=>$value->reviewBy->personal->FullName,
                            'scoreEmployee'=>number_format($value->EmployeePerformanceScore,2),
                            'avgValues'=>number_format($value->AvgValues,2),
                        ];
                   }
                   $i++;
                }
            }

            if($pasubordinate!=null){
                $i=0;
                foreach ($pasubordinate as $key => $value) {
                   if($i==0){
                        $_valuesSubordinate1 = [
                            'by'=>$value->reviewBy->personal->FullName,
                            'scoreEmployee'=>number_format($value->EmployeePerformanceScore,2),
                            'avgValues'=>number_format($value->AvgValues,2),
                        ];
                   }else{
                        $_valuesSubordinate1 = [
                            'by'=>$value->reviewBy->personal->FullName,
                            'scoreEmployee'=>number_format($value->EmployeePerformanceScore,2),
                            'avgValues'=>number_format($value->AvgValues,2),
                        ];
                   }
                   $i++;
                }
            }
        }
        return [
            'model'=>$modelPAC,
            'self'=>$_selfScore,
            'peers1'=>$_valuesPeers1,
            'peers2'=>$_valuesPeers2,
            'superior1'=>$_superior1score,
            'superior2'=>$_superior2score,
            'subordinate1'=>$_valuesSubordinate1,
            'subordinate2'=>$_valuesSubordinate2,
            'flag'=>$flag,
        ];
    }

    /**
     * {periodeid}
     */
    public function actionExport($id){
        $role=Yii::$app->session->has('role')?Yii::$app->session->get('role'):null;
        $isSuperior = Yii::$app->session->has('isSuperior')?Yii::$app->session->get('isSuperior'):false;
        $eid = Yii::$app->session->get('employeeid');
        $query = Pacomponent::find()
                            ->innerJoin('employment', 'pacomponent.EmployeeID=employment.EmployeeID')
                            ->innerJoin('personalinfo', 'personalinfo.PersonalID=employment.PersonalID')
                            ->where(['pacomponent.PeriodeID'=>$id])
                            ->all();
        if($role=='user' && $isSuperior){
            $modelpa = Performanceappraisal::find()
                            ->where(['SuperiorID1'=>$eid])
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
                                ->where(['in','pacomponent.PerformanceAppraisalID',$ids])
                                ->andWhere(['pacomponent.PeriodeID'=>$id])
                                ->all();
        }
        header("Content-Disposition: attachment; filename=\"DaftarPenilaianKinerja.xlsx\"");
        \moonland\phpexcel\Excel::widget([
            'models' => $query,
            'mode' => 'export', 
            'setFirstTitle'=>true,
            'columns' => [
                'periode.Start',
                'periode.End',
                'EmployeeID',
                'employee.personal.FullName',
                'EmployeeScore',
                'Self',
                'Peers',
                'SubordinatesToSuperior',
                'SuperiorToSubordinates',
                'TotalScore',
            ], 
            'headers'=>[
                'periode.Start'=>'Start Periode',
                'periode.End'=>'End Periode',
                'EmployeeScore'=>'Employee Score',
                'Self'=>'Self Core Values',
                'Peers'=>'Peers Core Values',
                'SubordinatesToSuperior'=>'Subordinate Core Values',
                'SuperiorToSubordinates'=>'Superior Core Values',
                'TotalScore'=>'Total Score'
            ],
        ]);
    }

    /**
     * {periodeid}
     */
    public function actionExportPenilai($id){
        $pa = Performanceappraisal::find()
                        ->where(['PeriodeID'=>$id])
                        ->all();
        header("Content-Disposition: attachment; filename=\"DaftarKaryawanPenilai.xlsx\"");
        \moonland\phpexcel\Excel::widget([
            'models' => $pa,
            'mode' => 'export', 
            'setFirstTitle'=>true,
            'columns' => [
                'periode.Start',
                'periode.End',
                'EmployeeID',
                'employee.personal.FullName',
                'peersID1.personal.FullName',
                'peersID2.personal.FullName',
                'superiorID1.personal.FullName',
                'superiorID2.personal.FullName',
                'subordinateID1.personal.FullName',
                'subordinateID1.personal.FullName',
                'Status'
            ], 
            'headers'=>[
                'periode.Start'=>'Start Periode',
                'periode.End'=>'End Periode',
                'peersID1.personal.FullName'=>'Peers1',
                'eersID2.personal.FullName'=>'Peers2',
                'superiorID1.personal.FullName'=>'SuperiorID1',
                'superiorID2.personal.FullName'=>'SuperiorID2',
                'subordinateID1.personal.FullName'=>'SubordinateID1',
                'subordinateID1.personal.FullName'=>'SubordinateID1',
            ],
        ]);
    }

    public function actionSavetrack($id){
        if($_POST){
            $model = PAComponent::find()
                                ->where(['PAComponentID'=>$id])
                                ->one();
            $model->TrackRecord = $_POST['track'];
            $model->save(false);

            echo json_encode([
                'status'=>1,
                'message'=>"Track Record has been updated.",
                'url'=>Url::to(['detail-nilai','id'=>$id]),
            ]);
        }else{
            echo json_encode([
                'status'=>0,
                'message'=>'Something went wrong'
            ]);
        }
    }
    /**
     * {pacomponentid} {employeeid} {periodeid}
     */
    public function actionGenpdf($id=null,$eid=null,$pid=null){
        $formed = $this->formeddetailnilai($id,$eid,$pid);
        $mpdf = new mPDF();
        // return $this->renderPartial('formatdetailnilai',$formed);
        $mpdf->WriteHTML($this->renderPartial('formatdetailnilai',$formed));
        $mpdf->Output('DetailNilai.pdf', 'D');
    }

    /**
     * create notif
     * {padata} 
     */
    private function notif($pa){
        if($pa!=null){
            $_arr=[
                'self'=>$pa->EmployeeID,
                'peersid1'=>$pa->PeersID1,
                'peersid2'=>$pa->PeersID2,
                'superiorid1'=>$pa->SuperiorID1,
                'superiorid2'=>$pa->SuperiorID2,
                'subordinateid1'=>$pa->SubordinateID1,
                'subordinateid2'=>$pa->SubordinateID2,
            ];
            if($_arr['self']!=null){
                $model = new Notif();
                $model->Created_at = date('Y-m-d H:i:s');
                $model->Message = 'Silahkan melakukan penilaian Self Performance Appraisal';
                $model->To = $_arr['self'];
                $model->save(false);
            }
            if($_arr['peersid1']!=null){
                $model = new Notif();
                $model->Created_at = date('Y-m-d H:i:s');
                $model->Message = 'Silahkan melakukan penilaian Peers1 Performance Appraisal kepada '.$pa->peersID1->personal->FullName;
                $model->To = $_arr['peersid1'];
                $model->save(false);
            }
            if($_arr['peersid2']!=null){
                $model = new Notif();
                $model->Created_at = date('Y-m-d H:i:s');
                $model->Message = 'Silahkan melakukan penilaian Peers2 Performance Appraisal kepada '.$pa->peersID2->personal->FullName;
                $model->To = $_arr['peersid2'];
                $model->save(false);
            }
            if($_arr['superiorid1']!=null){
                $model = new Notif();
                $model->Created_at = date('Y-m-d H:i:s');
                $model->Message = 'Silahkan melakukan penilaian Superior1 Performance Appraisal kepada '.$pa->superiorID1->personal->FullName;
                $model->To = $_arr['superiorid1'];
                $model->save(false);
            }
            if($_arr['superiorid2']!=null){
                $model = new Notif();
                $model->Created_at = date('Y-m-d H:i:s');
                $model->Message = 'Silahkan melakukan penilaian Superior2 Performance Appraisal kepada '.$pa->superiorID2->personal->FullName;
                $model->To = $_arr['superiorid2'];
                $model->save(false);
            }
            if($_arr['subordinateid1']!=null){
                $model = new Notif();
                $model->Created_at = date('Y-m-d H:i:s');
                $model->Message = 'Silahkan melakukan penilaian Subordinate1 Performance Appraisal kepada '.$pa->subordinateID1->personal->FullName;
                $model->To = $_arr['subordinateid1'];
                $model->save(false);
            }
            if($_arr['subordinateid2']!=null){
                $model = new Notif();
                $model->Created_at = date('Y-m-d H:i:s');
                $model->Message = 'Silahkan melakukan penilaian Subordinate2 Performance Appraisal kepada '.$pa->subordinateID2->personal->FullName;
                $model->To = $_arr['subordinateid2'];
                $model->save(false);
            }
        }
    }
    public function beforeAction($action) 
    { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action); 
    }
    /**
     * Finds the Periode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Periode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Periode::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
