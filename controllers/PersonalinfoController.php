<?php

namespace app\controllers;

use Yii;
use app\models\Personalinfo;
use app\models\PersonalinfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Identitytype;
use app\models\Gender;
use app\models\Religion;
use app\models\Statuspersonal;
use app\models\Employeestatus;
use app\models\Organization;
use app\models\Jobposition;
use app\models\Jobtitle;
use app\models\Joblevel;
use app\models\Squad;
use app\models\Employment;
use app\models\User;
use yii\helpers\Url;
/**
 * PersonalinfoController implements the CRUD actions for Personalinfo model.
 */
class PersonalinfoController extends Controller
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
     * Lists all Personalinfo models.
     * @return mixed
     */
    public function actionIndex($field=null)
    {
        if(Yii::$app->session->has('personalid')){
            Yii::$app->session->remove('personalid');
        }
        $searchModel = new PersonalinfoSearch();
        $searchModel->field = $field;

        if ($searchModel->load(Yii::$app->request->post())){
            $_data = Yii::$app->request->post()['PersonalinfoSearch'];
            $searchModel->field = $_data['field'];
            $this->redirect(['index','field'=>$searchModel->field]);
        }
        $dataProvider = $searchModel->search($field);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Personalinfo model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $_organization ='-';
        $_jobPosition ='-';
        $_jobTitle = '-';
        $_level = '-';
        $_squad ='-';
        $_atasan = '-';
        if($model->PersonalID!=null && $model->employments!=null){
            $_organization = $model->employments->organization==null?'-':$model->employments->organization->OrganizationName;
            $_jobPosition = $model->employments->jobPosition==null?'-':$model->employments->jobPosition->JobPositionName;
            $_jobTitle = $model->employments->jobTitle==null?'-':$model->employments->jobTitle->JobTitleName;
            $_level = $model->employments->level==null?'-':$model->employments->level->LevelName;
            $_squad = $model->employments->squad==null?'-':$model->employments->squad->SquadName;
            $_atasan = $model->employments->employeeSuperior==null?'-':$model->employments->employeeSuperior->personal->FullName;
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
            'organization'=>$_organization,
            'jobPosition'=>$_jobPosition,
            'jobTitle'=>$_jobTitle,
            'level'=>$_level,
            'squad'=>$_squad,
            'atasan'=>$_atasan,
        ]);
    }

    /**
     * Creates a new Personalinfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Personalinfo();
        $identity = Identitytype::find()->all();
        $gender = Gender::find()->all();
        $gender_list = [];
        foreach ($gender as $key => $value) {
           $gender_list[$value->GenderID] = $value->Name;
        }
        $religion = Religion::find()->all();
        $status = Statuspersonal::find()->all();

        $modelEmployment = new Employment();
        $statusEmployment = Employeestatus::find()->all();
        $atasan = Employment::find()
                        ->joinWith('jobPosition')
                        ->joinWith('personal')
                        // ->where(['employment.EmployeeSuperiorID'=>null])
                        ->andWhere(['<>','jobposition.JobPositionName','Staff'])
                        ->orderBy(['jobposition.Level'=>SORT_ASC,
                                    'personalinfo.FullName'=>SORT_ASC])
                        ->all();
        $organization = Organization::find()->all();
        $jobposition = Jobposition::find()->all();
        $jobtitle = Jobtitle::find()->all();
        $joblevel = Joblevel::find()->all();
        $squad = Squad::find()->all();

        return $this->render('create', [
            'model' => $model,
            'modelEmployment' => $modelEmployment,
            'identity'=>$identity,
            'gender'=>$gender_list,
            'religion'=>$religion,
            'status'=>$status,
            'statusEmployment'=>$statusEmployment,
            'organization'=>$organization,
            'atasan'=>$atasan,
            'jobposition'=>$jobposition,
            'jobtitle'=>$jobtitle,
            'joblevel'=>$joblevel,
            'squad'=>$squad,
            'readonly'=>false,
        ]);
    }
    /**
     * Updates an existing Personalinfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$type=null)
    {
        if($id==0&&$type=='self'){
            Yii::$app->session->setFlash('nopersonal', "Anda tidak memiliki data personal!");
            return $this->redirect(['index']);
        }
        $model = $this->findModel($id);
        $identity = Identitytype::find()->all();
        $gender = Gender::find()->all();
        $gender_list = [];
        foreach ($gender as $key => $value) {
           $gender_list[$value->GenderID] = $value->Name;
        }
        $religion = Religion::find()->all();
        $status = Statuspersonal::find()->all();

        $modelEmployment = Employment::find()
                                ->where(['PersonalID'=>$id])
                                ->one();
        if($modelEmployment==null){
            $modelEmployment= new Employment();
        }
        $statusEmployment = Employeestatus::find()->all();
        $atasan = Employment::find()
                        ->joinWith('jobPosition')
                        ->joinWith('personal')
                        // ->where(['employment.EmployeeSuperiorID'=>null])
                        ->andWhere(['<>','jobposition.JobPositionName','Staff'])
                        ->orderBy(['jobposition.Level'=>SORT_ASC,
                                    'personalinfo.FullName'=>SORT_ASC])
                        ->all();
        $organization = Organization::find()->all();
        $jobposition = Jobposition::find()->all();
        $jobtitle = Jobtitle::find()->all();
        $joblevel = Joblevel::find()->all();
        $squad = Squad::find()->all();

        return $this->render('update', [
            'model' => $model,
            'modelEmployment' => $modelEmployment,
            'identity'=>$identity,
            'gender'=>$gender_list,
            'religion'=>$religion,
            'status'=>$status,
            'statusEmployment'=>$statusEmployment,
            'organization'=>$organization,
            'atasan'=>$atasan,
            'jobposition'=>$jobposition,
            'jobtitle'=>$jobtitle,
            'joblevel'=>$joblevel,
            'squad'=>$squad,
            'readonly'=>$type!=null?true:false,
        ]);
    }

    public function actionSave(){
        $_post = Yii::$app->request->post();
        $model = new Personalinfo();
        $modelUser = new User();
        if($_post['mode']==1){
            $model = $this->findModel($_GET['id']);
            if($model->UserID!=null){
                $modelUser = User::find()
                ->where(['UserID'=>$model->UserID])
                ->one();
            }
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post())) {
                $password = $_post['Personalinfo']['password'];
                if(($_post['mode']==1 && $modelUser->password!=$password) || $_post['mode']==0){
                    $modelUser->password = md5($password);
                }
                $modelUser->username = $_post['Personalinfo']['username'];
                $modelUser->save(false);
                
                $model->UserID=$modelUser->UserID;
                $model->save();
                Yii::$app->session->set('personalid',$model->PersonalID);
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Data Personal Info has been saved.',
                    ],
                    'code' => 0,
                ];
            } else {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'An error occured.',
                    ],
                    'code' => 1, // Some semantic codes that you know them for yourself
                ];
            }
        }
    }

    public function actionSaveemployee(){
        $_post = Yii::$app->request->post();
        $model = new Employment();
        $_personalid=null;
        if(Yii::$app->session->has('personalid')){
            $_personalid = Yii::$app->session->get('personalid');
        }else{
            $_personalid =$_GET['id'];
        }
        if($_post['mode']==1){
            $model = Employment::find()
                                ->where(['PersonalID'=>$_GET['id']])
                                ->one();
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post())) {
                if($_personalid!=null && $_personalid!=""){
                    $model->PersonalID = $_personalid;
                    $model->save();
                    if(Yii::$app->session->has('personalid')){
                        Yii::$app->session->remove('personalid');
                    }
                    return [
                        'data' => [
                            'success' => true,
                            'message' => 'Employment has been saved.',
                            'url'=>Url::to(['view','id'=>$model->PersonalID]),
                        ],
                        'code' => 0, // Some semantic codes that you know them for yourself
                    ];
                }
            } else {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'An error occured.',
                    ],
                    'code' => 1, // Some semantic codes that you know them for yourself
                ];
            }
        }
    }

    public function actionExport1(){
        $model = Personalinfo::find()->all();
        header("Content-Disposition: attachment; filename=\"DaftarPegawai.xlsx\"");
        \moonland\phpexcel\Excel::widget([
            'models' => $model,
            'mode' => 'export', 
            'setFirstTitle'=>true,
            'columns' => [
                'PersonalID',
                'FullName',
                'identityType.Name',
                'IdentityNumber',
                'IdentityExpiryDate',
                'PlaceOfBirth',
                'DateOfBirth',
                'status.Name',
                'gender.Name',
                'religion.Name',
                'PhoneNumber',
                'Address',
                'Email',
                'employments.EmployeeID',
                'employments.EmployeeNumber',
                'employments.JoinDate',
                'employments.employeeStatus.Name',
                'employments.organization.OrganizationName',
                'employments.jobPosition.JobPositionName',
                'employments.AKA_JobPosition',
                'employments.jobTitle.JobTitleName',
                'employments.level.LevelName',
                'employments.squad.SquadName',
                'employments.employeeSuperior.personal.FullName',
            ], 
            'headers' => ['identityType.Name' => 'Identity Type', 
                        'status.Name'=>'Status',
                        'gender.Name'=>'Gender',
                        'religion.Name'=>'Religion',
                        'employments.employeeStatus.Name'=>'Status Employment',
                        'employments.employeeSuperior.personal.FullName'=>'Superior Name',
            ], 
        ]);
    }

    public function actionExport(){
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $model = Personalinfo::find()->all();
        $objPHPExcel->getActiveSheet()->mergeCells('A1:X1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Daftar Karyawan PT.Property - '.date('d-m-Y'));
        $style = array(
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->setCellValue('A2','Personal ID')
                    ->setCellValue('B2','Name')
                    ->setCellValue('C2','Identity Type')
                    ->setCellValue('D2','Identity Number')
                    ->setCellValue('E2','Identity Expiry Date')
                    ->setCellValue('F2','Place of Birth')
                    ->setCellValue('G2','Date of Birth')
                    ->setCellValue('H2','Status')
                    ->setCellValue('I2','Gender')
                    ->setCellValue('J2','Religion')
                    ->setCellValue('K2','Phone Number')
                    ->setCellValue('L2','Address')
                    ->setCellValue('M2','Email')
                    ->setCellValue('N2','Employee ID')
                    ->setCellValue('O2','Employee Number')
                    ->setCellValue('P2','Join Date')
                    ->setCellValue('Q2','Status Employment')
                    ->setCellValue('R2','Organization Name')
                    ->setCellValue('S2','Job Position')
                    ->setCellValue('T2','AKA Job Position')
                    ->setCellValue('U2','Job Title')
                    ->setCellValue('V2','Level Name')
                    ->setCellValue('W2','Squad Name')
                    ->setCellValue('X2','Superior Name');
        $i=3;
        foreach($model as $key=>$value){
            $_organization = $value->employments->organization==null?'-':$value->employments->organization->OrganizationName;
            $_jobPosition = $value->employments->jobPosition==null?'-':$value->employments->jobPosition->JobPositionName;
            $_jobTitle = $value->employments->jobTitle==null?'-':$value->employments->jobTitle->JobTitleName;
            $_level = $value->employments->level==null?'-':$value->employments->level->LevelName;
            $_squad = $value->employments->squad==null?'-':$value->employments->squad->SquadName;
            $_atasan = $value->employments->employeeSuperior==null?'-':$value->employments->employeeSuperior->personal->FullName;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$value->PersonalID)
                                        ->setCellValue('B'.$i,$value->FullName)
                                        ->setCellValue('C'.$i,$value->identityType->Name)
                                        ->setCellValue('D'.$i,$value->IdentityNumber)
                                        ->setCellValue('E'.$i,$value->IdentityExpiryDate)
                                        ->setCellValue('F'.$i,$value->PlaceOfBirth)
                                        ->setCellValue('G'.$i,$value->DateOfBirth)
                                        ->setCellValue('H'.$i,$value->status->Name)
                                        ->setCellValue('I'.$i,$value->gender->Name)
                                        ->setCellValue('J'.$i,$value->religion->Name)
                                        ->setCellValue('K'.$i,$value->PhoneNumber)
                                        ->setCellValue('L'.$i,$value->Address)
                                        ->setCellValue('M'.$i,$value->Email)
                                        ->setCellValue('N'.$i,$value->employments->EmployeeID)
                                        ->setCellValue('O'.$i,$value->employments->EmployeeNumber)
                                        ->setCellValue('P'.$i,$value->employments->JoinDate)
                                        ->setCellValue('Q'.$i,$value->employments->employeeStatus->Name)
                                        ->setCellValue('R'.$i,$_organization)
                                        ->setCellValue('S'.$i,$_jobPosition)
                                        ->setCellValue('T'.$i,$value->employments->AKA_JobPosition)
                                        ->setCellValue('U'.$i,$_jobTitle)
                                        ->setCellValue('V'.$i,$_level)
                                        ->setCellValue('W'.$i,$_squad)
                                        ->setCellValue('X'.$i,$_atasan);
            $i++;
        }
        $xlsName = "DaftarKaryawan_".date('d-m-Y').".xlsx";
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$xlsName.'"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }
    /**
     * Deletes an existing Personalinfo model.
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
     * Finds the Personalinfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Personalinfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Personalinfo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
