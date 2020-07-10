<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonalinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hasil Penilaian Kinerja Karyawan';
if(Yii::$app->session->get('isSuperior') || Yii::$app->session->get('role')=='admin'){
    $this->params['breadcrumbs'][] = ['label' => 'Hasil Penilaian', 'url' => ['hasil-penilaian']];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hasilpenilaian-view">
    <div class='row'>
        <div class='col-md-2'>
            <p><h4>Periode Penilaian</h4></p>
        </div>
        <div class='col-md-3'>
            <p>
                <h4><?php echo Yii::$app->formatter->format($periode->Start, 'date')." - ".Yii::$app->formatter->format($periode->End, 'date' )?></h4>
            </p>
        </div>
        <div class='col-md-6'>
            <p>
                <?= Html::a('Export ToExcel', ['export','id'=>$periode->PeriodeID], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
    </div>
    <?php echo $this->render('_searchpenilaian', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'Karyawan',
                    'format'=>'raw',
                    'value'=>'employee.personal.FullName'
                ],
                [
                    'attribute'=>'Nilai Kinerja Karyawan',
                    'format'=>['decimal',2],
                    'value'=>'EmployeeScore'
                ],
                [
                    'attribute'=>'Core Values-Self',
                    'format'=>['decimal',2],
                    'value'=>'Self'
                ],
                [
                    'attribute'=>'Core Values-Peers',
                    'format'=>['decimal',2],
                    'value'=>'Peers'
                ],
                [
                    'attribute'=>'Core Values-Superior',
                    'format'=>['decimal',2],
                    'value'=>'SuperiorToSubordinates'
                ],
                [
                    'attribute'=>'Core Values-Subordinate',
                    'format'=>['decimal',2],
                    'value'=>'SubordinatesToSuperior'
                ],
                [
                    'attribute'=>'Nilai Akhir',
                    'format'=>['decimal',4],
                    'value'=>'TotalScore'
                ],

                [
                    'class'    => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'header'=>'Action',
                    'buttons'  => [
                        'view' => function ($url, $model) {
                            $url = Url::to(['detail-nilai', 'id' => $model->PAComponentID]);
                            return Html::a('<span class="fa fa-eye"></span>', $url, ['title' => 'Lihat Detail Nilai']);
                        },
                    ],
                ],
            ],
        ]); ?>
    <?php Pjax::end(); ?>

</div>
