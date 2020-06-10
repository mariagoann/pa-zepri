<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonalinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Karyawan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personalinfo-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute'=>'Nama',
                    'format'=>'raw',
                    'value'=>'FullName'
                ],
                [
                    'attribute'=>'Organization',
                    'format'=>'raw',
                    'value'=>'employments.organization.OrganizationName'
                ],
                [
                    'attribute'=>'Squad',
                    'format'=>'raw',
                    'value'=>'employments.squad.SquadName'
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>

</div>
