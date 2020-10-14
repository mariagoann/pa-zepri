<?php

namespace app\controllers;

use Yii;
use app\models\Jobposition;
use app\models\JobpositionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JobpositionController implements the CRUD actions for Jobposition model.
 */
class JobpositionController extends Controller
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
     * Lists all Jobposition models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JobpositionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Jobposition model.
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
     * Creates a new Jobposition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Jobposition();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Jobposition model.
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

    public function actionExport1(){
        $model = Jobposition::find()->all();
        header("Content-Disposition: attachment; filename=\"DaftarJobPosition.xlsx\"");
        \moonland\phpexcel\Excel::widget([
            'models' => $model,
            'mode' => 'export', 
            'setFirstTitle'=>true,
            'columns' => [
                'JobPositionID',
                'CodeJobPosition',
                'JobPositionName',
                'Level'
            ], 
            'headers'=>[
                'CodeJobPosition'=>'Code Job Position'
            ],
        ]);
    }

    public function actionExport(){
        $model = Jobposition::find()->all();
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Daftar Job Position - '.date('d-m-Y'));
        $style = array(
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->setCellValue('A2','JobPositionID')
                    ->setCellValue('B2','Code Job Position')
                    ->setCellValue('C2','Job Position Name')
                    ->setCellValue('D2','Level');
        $i=3;
        foreach ($model as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$value->JobPositionID)
                                                        ->setCellValue('B'.$i,$value->CodeJobPosition)
                                                        ->setCellValue('C'.$i,$value->JobPositionName)
                                                        ->setCellValue('D'.$i,$value->Level);
            $i++;
        }
        $xlsName = "DaftarJobPosition_".date('d-m-Y').".xlsx";
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$xlsName.'"');
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
    }

    /**
     * Deletes an existing Jobposition model.
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
     * Finds the Jobposition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Jobposition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Jobposition::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
