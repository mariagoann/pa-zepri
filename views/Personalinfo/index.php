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
                'FullName',
                [
                    'attribute'=>'Organization',
                    'format'=>'raw',
                    'value'=>'employments.organization.OrganizationName'
                ],
                [
                    'attribute'=>'Job Position',
                    'format'=>'raw',
                    'value'=>function($data){
                        $job='-';
                        if($data->employments!=null){
                            $job = $data->employments->AKA_JobPosition!=null?$data->employments->AKA_JobPosition
                                            :$data->employments->jobPosition->JobPositionName;
                        }
                        return $job;
                    }
                ],
                [
                    'attribute'=>'Job Level',
                    'format'=>'raw',
                    'value'=>'employments.level.LevelName',
                ],
                [
                    'attribute'=>'Job Title',
                    'format'=>'raw',
                    'value'=>'employments.jobTitle.JobTitleName',
                ],
                [
                    'attribute'=>'Squad',
                    'format'=>'raw',
                    'value'=>'employments.squad.SquadName',
                ],
                [
                    'attribute'=>'Atasan Langsung',
                    'format'=>'raw',
                    'value'=>'employments.employeeSuperior.personal.FullName',
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>

</div>
