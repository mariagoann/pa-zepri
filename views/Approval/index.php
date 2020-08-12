<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PeriodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Approval Karyawan Penilai';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="periode-index">
    <p>
        <h4>Periode Penilaian</h4>
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
                'attribute'=>'Status Periode',
                'format'=>'raw',
                'value'=>function($data){
                    return $data->Status=="1"?"Active":"Non Active";
                }
            ],

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view} &nbsp; {end}',
                'header'=>'Action',
                'buttons'  => [
                    'view' => function ($url, $model) {
                        $url = Url::to(['view', 'id' => $model->PeriodeID]);
                        return Html::a('<span class="fa fa-check"></span>', $url, ['title' => 'Approve Karyawan Penilai']);
                    },
                    'end' => function ($url, $model) {
                        $url = '#';
                        return Html::a('<span class="fa fa-ban"></span>', $url, ['title' => 'Periode Penilaian Selesai']);
                    },
                ],
                'visibleButtons'=>[
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
