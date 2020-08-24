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
use app\models\Notif;
use app\models\User;
use yii\swiftmailer\Mailer;

/**
 * PeriodeController implements the CRUD actions for Periode model.
 */
class ApprovalController extends Controller
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
        if($_POST!=null){
            $_stat = [];
            $_mode = $_POST['mode'];
            $_alasan = $_POST['alasan'];
            if(intval($_mode)==1){
                $update = Performanceappraisal::updateAll(['Status' => '1'], ['=','PeriodeID', $id]);
                $allpa = Performanceappraisal::find()->where(['PeriodeID'=>$id])->all();
                if($allpa!=null){
                    foreach ($allpa as $key=>$value) {
                        $this->notifPenilai($value);
                    }
                }
                $_stat = [
                    'status'=>1,
                    'message'=>"All data have been approved and activated successfully.",
                    'url'=>Url::to(['view','id'=>$id]),
                ];
            }else{
                $update = Performanceappraisal::updateAll(['Status' => '0'], ['=','PeriodeID', $id]);
                $this->notifAdmin($id,$_alasan);
                $_stat = [
                    'status'=>1,
                    'message'=>"Data have been rejected successfully.",
                    'url'=>Url::to(['view','id'=>$id]),
                ];
            }
            echo json_encode($_stat);
        }else{
            echo json_encode([
                'status'=>0,
                'message'=>'Something went wrong',
                'url'=>Url::to(['view','id'=>$id]),
            ]);
        }
    }
    private function notifAdmin($id,$_message){
        $periode = $this->findModel($id);
        $message = "Tolak penilaian pada <br> Periode ".$periode->Start." s/d ".$periode->End;
        //get all admin
        $admins = User::find()
                        ->where(['role'=>'admin'])
                        ->all();
        if($admins!=null){
            foreach ($admins as $key => $value) {
                $model = new Notif();
                $model->Created_at = date('Y-m-d H:i:s');
                $model->Message = $message;
                $model->TypeTo = 1;
                $model->To = $value->UserID;
                $model->Notes = $_message;
                $model->GoTo = Url::to(['periode/view','id'=>$id]);
                $model->PeriodeID  = $id;
                $model->save(false);
            }
        }
    }
    /**
     * send notif to Penilai
     */
    private function notifPenilai($pa){
        if($pa!=null){
            $subject=null;
            $message = null;
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
                $model->Message = 'Silahkan melakukan penilaian <br> Self Performance Appraisal';
                $model->To = $_arr['self'];
                $model->save(false);
                
                //send email
                $subject = "Self Performance Appraisal";
                $message = "Hi ".$pa->employee->personal->FullName.", <br><br>
                            Segera lakukan penilaian kinerja kepada diri anda. <br><br>
                            Regards, <br>
                            People and Culture Team.";
                $this->sendEmail($pa->employee->personal->Email, $message, $subject);
            }
            if($_arr['peersid1']!=null){
                $model = new Notif();
                $model->Created_at = date('Y-m-d H:i:s');
                $model->Message = 'Silahkan melakukan penilaian <br> Peers1 PA kepada '.$pa->employee->personal->FullName;
                $model->To = $_arr['peersid1'];
                $model->PeriodeID  = $pa->PeriodeID;
                $model->save(false);

                //send email
                $subject = "Peers Performance Appraisal";
                $message = "Hi ".$pa->peersID1->personal->FullName.", <br><br>
                            Segera lakukan penilaian kinerja Peers kepada rekan anda ".$pa->employee->personal->FullName.". <br><br>
                            Regards, <br>
                            People and Culture Team.";
                $this->sendEmail($pa->peersID1->personal->Email, $message, $subject);
            }
            if($_arr['peersid2']!=null){
                $model = new Notif();
                $model->Created_at = date('Y-m-d H:i:s');
                $model->Message = 'Silahkan melakukan penilaian <br> Peers2 PA kepada '.$pa->employee->personal->FullName;
                $model->To = $_arr['peersid2'];
                $model->PeriodeID  = $pa->PeriodeID;
                $model->save(false);

                //send email
                $subject = "Peers Performance Appraisal";
                $message = "Hi ".$pa->peersID2->personal->FullName.", <br><br>
                            Segera lakukan penilaian kinerja Peers kepada rekan anda ".$pa->employee->personal->FullName.". <br><br>
                            Regards, <br>
                            People and Culture Team.";
                $this->sendEmail($pa->peersID2->personal->Email, $message, $subject);
            }
            if($_arr['superiorid1']!=null){
                $model = new Notif();
                $model->Created_at = date('Y-m-d H:i:s');
                $model->Message = 'Silahkan melakukan penilaian <br> Superior1 PA kepada '.$pa->employee->personal->FullName;
                $model->To = $_arr['superiorid1'];
                $model->PeriodeID  = $pa->PeriodeID;
                $model->save(false);

                //send email
                $subject = "Superior Performance Appraisal";
                $message = "Hi ".$pa->superiorID1->personal->FullName.", <br><br>
                            Segera lakukan penilaian kinerja untuk atasan langsung anda ".$pa->employee->personal->FullName.". <br><br>
                            Regards, <br>
                            People and Culture Team.";
                $this->sendEmail($pa->superiorID1->personal->Email, $message, $subject);
            }
            if($_arr['superiorid2']!=null){
                $model = new Notif();
                $model->Created_at = date('Y-m-d H:i:s');
                $model->Message = 'Silahkan melakukan penilaian <br> Superior2 PA kepada '.$pa->employee->personal->FullName;
                $model->To = $_arr['superiorid2'];
                $model->PeriodeID  = $pa->PeriodeID;
                $model->save(false);

                //send email
                $subject = "Superior Performance Appraisal";
                $message = "Hi ".$pa->superiorID2->personal->FullName.", <br><br>
                            Segera lakukan penilaian kinerja untuk atasan langsung anda ".$pa->employee->personal->FullName.". <br><br>
                            Regards, <br>
                            People and Culture Team.";
                $this->sendEmail($pa->superiorID2->personal->Email, $message, $subject);
            }
            if($_arr['subordinateid1']!=null){
                $model = new Notif();
                $model->Created_at = date('Y-m-d H:i:s');
                $model->Message = 'Silahkan melakukan penilaian <br> Subordinate1 PA kepada '.$pa->employee->personal->FullName;
                $model->To = $_arr['subordinateid1'];
                $model->PeriodeID  = $pa->PeriodeID;
                $model->save(false);

                //send email
                $subject = "Subordinate Performance Appraisal";
                $message = "Hi ".$pa->subordinateID1->personal->FullName.", <br><br>
                            Segera lakukan penilaian kinerja untuk bawahan langsung anda ".$pa->employee->personal->FullName.". <br><br>
                            Regards, <br>
                            People and Culture Team.";
                $this->sendEmail($pa->subordinateID1->personal->Email, $message, $subject);
            }
            if($_arr['subordinateid2']!=null){
                $model = new Notif();
                $model->Created_at = date('Y-m-d H:i:s');
                $model->Message = 'Silahkan melakukan penilaian <br> Subordinate2 PA kepada '.$pa->employee->personal->FullName;
                $model->To = $_arr['subordinateid2'];
                $model->PeriodeID  = $pa->PeriodeID;
                $model->save(false);

                //send email
                $subject = "Subordinate Performance Appraisal";
                $message = "Hi ".$pa->subordinateID2->personal->FullName.", <br><br>
                            Segera lakukan penilaian kinerja untuk bawahan langsung anda ".$pa->employee->personal->FullName.". <br><br>
                            Regards, <br>
                            People and Culture Team.";
                $this->sendEmail($pa->subordinateID2->personal->Email, $message, $subject);
            }
        }
    }
    private function sendEmail($to, $message, $subject){
        $send = 'abc';
        if($to!=null && $to!=''){
            try {
                $send = Yii::$app->mailer->compose()
                    ->setFrom('performanceappraisalproperty@gmail.com', 'Performance Appraisal')
                    ->setTo($to)
                    ->setSubject($subject)
                    ->setHtmlBody($message)
                    ->send();
            } catch (Exception $th) {
                $send = $th->getMessage();
            }
        }
        return $send;
    }
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

    public function actionSend(){
        var_dump($this->sendEmail('gorettis010@gmail.com','Test Message', 'Test Subject'));
    }
    public function beforeAction($action) 
    { 
        $this->enableCsrfValidation = false; 
        return parent::beforeAction($action); 
    }
    protected function findModel($id)
    {
        if (($model = Periode::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
