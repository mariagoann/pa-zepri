<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PeriodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Periode Penilaian';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="periode-index">
    <p>
        <?= Html::a('Periode Penilaian', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Tambah Periode', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'Periode',
                'format'=>'raw',
                'value'=>function($data){
                    return Yii::$app->formatter->format($data->Start, 'date') ." - ". Yii::$app->formatter->format($data->End, 'date'); 
                }
            ],
            [
                'attribute'=>'Batas Waktu Penilaian',
                'format'=>'raw',
                'value'=>function($data){
                    return Yii::$app->formatter->format($data->LastModified, 'date');
                }
            ],
            [
                'attribute'=>'Status',
                'format'=>'raw',
                'value'=>function($data){
                    return $data->Status=="1"?"Active":"Non Active";
                }
            ],

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{edit} &nbsp; {gen} &nbsp; {view} &nbsp; {end}',
                'header'=>'Action',
                'buttons'  => [
                    'edit' => function ($url, $model) {
                        $url = Url::to(['update', 'id' => $model->PeriodeID]);
                        return Html::a('<span class="fa fa-pencil"></span>', $url, ['title' => 'Update']);
                    },
                    'gen' => function ($url, $model) {
                        $url = Url::to(['generate', 'id' => $model->PeriodeID]);
                        return Html::a('<span class="fa fa-gear"></span>', $url, ['title' => 'Generate Karyawan Penilai']);
                    },
                    'view' => function ($url, $model) {
                        $url = Url::to(['view', 'id' => $model->PeriodeID]);
                        return Html::a('<span class="fa fa-eye"></span>', $url, ['title' => 'Lihat Karyawan Penilai']);
                    },
                    'end' => function ($url, $model) {
                        $url = '#';
                        return Html::a('<span class="fa fa-ban"></span>', $url, ['title' => 'Periode Penilaian Selesai']);
                    },
                ],
                'visibleButtons'=>[
                    'gen'=>function($model,$key, $index){
                        if($model->performanceappraisals!=null){
                            return false;
                        }else{
                            return true;
                        }
                    },
                    'view'=>function($model,$key, $index){
                        if($model->performanceappraisals!=null){
                            return true;
                        }else{
                            return false;
                        }
                    },
                    'end'=>function($model, $key, $index){
                        if($model->LastModified >= date('Y-m-d')){
                            return false;
                        }else{
                            return true;
                        }
                    }
                ],
            ],
        ],
    ]); ?>


</div>
