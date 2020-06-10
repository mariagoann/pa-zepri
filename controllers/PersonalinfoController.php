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
        if($model->PersonalID!=null){
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
                        ->where(['EmployeeSuperiorID'=>null])
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
        ]);
    }
    /**
     * Updates an existing Personalinfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
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
        $statusEmployment = Employeestatus::find()->all();
        $atasan = Employment::find()
                        ->where(['EmployeeSuperiorID'=>null])
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
        ]);
    }

    public function actionSave(){
        $_post = Yii::$app->request->post();
        $model = new Personalinfo();
        if($_post['mode']==1){
            $model = $this->findModel($_GET['id']);
        }
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
            $_personalid = $_GET['id'];
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
