<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PeriodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar periode yang harus anda nilai';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="periode-index">
<?php if (Yii::$app->session->hasFlash('outofdate')): ?>
    <div class="alert alert-warning alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <?= Yii::$app->session->getFlash('outofdate') ?>
    </div>
<?php endif; ?>
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
                'template' => '{nilai} &nbsp; {end}',
                'header'=>'Action',
                'buttons'  => [
                    'nilai' => function ($url, $model) {
                        $url = Url::to(['index', 'id' => $model->PeriodeID]);
                        return Html::a('<span class="fa fa-check"></span>', $url, ['title' => 'Lakukan Penilaian']);
                    },
                    'end' => function ($url, $model) {
                        $url = '#';
                        return Html::a('<span class="fa fa-ban"></span>', $url, ['title' => 'Periode Penilaian Selesai']);
                    },
                ],
                'visibleButtons'=>[
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
