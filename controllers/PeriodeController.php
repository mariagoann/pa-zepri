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
use yii\helpers\Url;

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

    /**
     * Displays a single Periode model.
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
     * Creates a new Periode model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Periode();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
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
        $_employee = Employment::find()->all();
        $_periode = $this->findModel($id);
        $_arr = [];
        if($_employee!=null){
            $i=0;
            foreach ($_employee as $key => $_value) {
               $__peers = null;
               $__subordinate = null;
               $_squad = $this->getPeers($_value->SquadID, $_value->JobPositionID, $_value->OrganizationID, $_value->EmployeeID);
               $_subordinate = $this->getSubordinate($_value->EmployeeID);
               if($_squad!=null){
                 $j=0;
                 foreach ($_squad as $key => $value) {
                     $__peers[$j] = [
                         'id'=>$value->EmployeeID,
                         'name'=>$value->personal->FullName,
                     ];
                     $j++;
                 }
               }
               if($_subordinate!=null){
                    $j=0;
                    foreach ($_squad as $key => $value) {
                        $__subordinate[$j] = [
                            'id'=>$value->EmployeeID,
                            'name'=>$value->personal->FullName,
                        ];
                        $j++;
                    }
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
                   'superior1name'=>$_superior1name
               ];
               $i++;
            } 
        }
        return $this->render('generate',[
            'employee'=>$_employee,
            'periode'=>$_periode,
            'arr'=>$_arr
        ]);
    }
    private function getPeers($sqid,$jpid, $orid, $except){
        $_squad = Employment::find()
                            ->where(['SquadID'=>$sqid])
                            ->andWhere(['JobPositionID'=>$jpid])
                            ->andWhere(['<>','EmployeeID',$except])
                            ->all();
        if($sqid==null){
            $_squad = Employment::find()
                        ->where(['OrganizationID'=>$orid])
                        ->andWhere(['JobPositionID'=>$jpid])
                        ->andWhere(['<>','EmployeeID',$except])
                        ->all();
        }
        shuffle($_squad);
        return $_squad;
    }

    private function getSubordinate($employeeid){
        $_subordinate = Employment::find()
                                ->where(['EmployeeSuperiorID'=>$employeeid])
                                ->andWhere(['<>','EmployeeID',$employeeid])
                                ->all();
        shuffle($_subordinate);
        return $_subordinate;
    }

    public function actionSave($id){
        if($_POST!=null){
            $_employee = $_POST['employeeid'];
            $_peers1 = $_POST['peersid1id'];
            $_peers2 = $_POST['peersid2id'];
            $_superior1 = $_POST['superiorid1'];
            $_subordinate1 = $_POST['subordinate1id'];
            $_subordinate2 = $_POST['subordinate2id'];
            for ($i=0; $i < count($_employee) ; $i++) { 
                $model = new Performanceappraisal();
                $model->EmployeeID = $_employee[$i];
                $model->PeersID1 = $_peers1[$i]==0?null:$_peers1[$i];
                $model->PeersID2 = $_peers2[$i]==0?null:$_peers2[$i];
                $model->SuperiorID1 = $_superior1[$i]==0?null:$_superior1[$i];
                $model->SuperiorID2 = null;
                $model->SubordinateID1 = $_subordinate1[$i]==0?null:$_subordinate1[$i];
                $model->SubordinateID2 = $_subordinate2[$i]==0?null:$_subordinate2[$i];
                $model->PeriodeID = $id;
                $model->save(false);
            }
            echo json_encode([
                'status'=>1,
                'message'=>'Data has been saved.',
                'url'=>Url::to(['index']),
            ]);
        }else{
            echo json_encode([
                'status'=>0,
                'message'=>'Something went wrong.'
            ]);
        }
    }

    /**
     * Finds the Periode model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Periode the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

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
