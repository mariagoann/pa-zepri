<?php

namespace app\controllers;

use Yii;
use app\models\Joblevel;
use app\models\JoblevelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JoblevelController implements the CRUD actions for Joblevel model.
 */
class JoblevelController extends Controller
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
     * Lists all Joblevel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JoblevelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Joblevel model.
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
     * Creates a new Joblevel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Joblevel();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Joblevel model.
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
     * Deletes an existing Joblevel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionExport1(){
        $model = Joblevel::find()->all();
        header("Content-Disposition: attachment; filename=\"DaftarJobLevel.xlsx\"");
        \moonland\phpexcel\Excel::widget([
            'models' => $model,
            'mode' => 'export', 
            'setFirstTitle'=>true,
            'columns' => [
                'LevelID',
                'CodeLevel',
                'LevelName',
            ], 
            'headers'=>[
                'CodeLevel'=>'Code Level'
            ],
        ]);
    }

    public function actionExport(){
        $model = Joblevel::find()->all();
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->mergeCells('A1:C1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Daftar Job Level - '.date('d-m-Y'));
        $style = array(
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($style);
        $objPHPExcel->getActiveSheet()->setCellValue('A2','LevelID')
                    ->setCellValue('B2','Code Level')
                    ->setCellValue('C2','Level Name');
        $i=3;
        foreach ($model as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$value->LevelID)
                                                        ->setCellValue('B'.$i,$value->CodeLevel)
                                                        ->setCellValue('C'.$i,$value->LevelName);
            $i++;
        }
        $xlsName = "DaftarLevel_".date('d-m-Y').".xlsx";
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
     * Finds the Joblevel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Joblevel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Joblevel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
