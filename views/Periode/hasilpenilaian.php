<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PeriodeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hasil Penilaian Kinerja Karyawan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="periode-index">
<?php if (Yii::$app->session->hasFlash('notevaluate')): ?>
    <div class="alert alert-warning alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <?= Yii::$app->session->getFlash('notevaluate') ?>
    </div>
<?php endif; ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
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
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'header'=>'Action',
                'buttons'  => [
                    'view' => function ($url, $model) {
                        $url = Url::to(['view-nilai', 'id' => $model->PeriodeID]);
                        if(Yii::$app->session->has('isSuperior')){
                            $isSuperior = Yii::$app->session->get('isSuperior');
                            $eid = Yii::$app->session->get('employeeid');
                            if(!$isSuperior){
                                $url = Url::to(['detail-nilai','id'=>null,'eid'=>$eid,'pid'=>$model->PeriodeID]);
                            }
                        }
                        return Html::a('<span class="fa fa-eye"></span>', $url, ['title' => 'Lihat Hasil Penilaian Kinerja Karyawan']);
                    },
                ],
            ],
        ],
    ]); ?>


</div>
