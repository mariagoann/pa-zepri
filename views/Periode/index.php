<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{edit} &nbsp; {gen} &nbsp; {view}',
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
                        $url = Url::to(['update', 'id' => $model->PeriodeID]);
                        return Html::a('<span class="fa fa-eye"></span>', $url, ['title' => 'Lihat Karyawan Penilai']);
                    },
                ]
            ],
        ],
    ]); ?>


</div>
