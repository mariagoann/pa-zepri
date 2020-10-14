<?php

namespace app\controllers;

use Yii;
use app\models\Jobtitle;
use app\models\JobtitleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JobtitleController implements the CRUD actions for Jobtitle model.
 */
class JobtitleController extends Controller
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
     * Lists all Jobtitle models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JobtitleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Jobtitle model.
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
     * Creates a new Jobtitle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Jobtitle();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Jobtitle model.
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
     * Deletes an existing Jobtitle model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionExport1(){
        $model = Jobtitle::find()->all();
        header("Content-Disposition: attachment; filename=\"DaftarJobTitle.xlsx\"");
        \moonland\phpexcel\Excel::widget([
            'models' => $model,
            'mode' => 'export', 
            'setFirstTitle'=>true,
            'columns' => [
                'JobTitleID',
                'CodeJobTitle',
                'JobTitleName',
            ], 
            'headers'=>[
                'CodeJobTitle'=>'Code Job Title'
            ],
        ]);
    }

    public function actionExport(){
        $model = Jobtitle::find()->all();
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Daftar Job Title - '.date('d-m-Y'));
        $style = array(
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->setCellValue('A2','JobTitleID')
                    ->setCellValue('B2','Code Job Title')
                    ->setCellValue('C2','Job Title Name');
        $i=3;
        foreach ($model as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$value->JobTitleID)
                                                        ->setCellValue('B'.$i,$value->CodeJobTitle)
                                                        ->setCellValue('C'.$i,$value->JobTitleName);
            $i++;
        }
        $xlsName = "DaftarJobTitle_".date('d-m-Y').".xlsx";
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$xlsName.'"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Jobtitle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Jobtitle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jobtitle::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
