<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Paparameter */

$this->title = $model->PAParameterID;
$this->params['breadcrumbs'][] = ['label' => 'Paparameters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="paparameter-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->PAParameterID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->PAParameterID], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'PAParameterID',
            'PerformanceValue',
            'PositiveContribution',
            'SelfImprovement',
            'EmployeePerformanceScore',
            'TeamImprovement',
            'AGILE',
            'PositifSelfAgile',
            'NegativeSelfAgile',
            'IMPACT',
            'PositiveSelfImpact',
            'NegativeSelfImpact',
            'UDPE',
            'PositiveSelfUDPE',
            'NegativeSelfUDPE',
            'Entrepreneurial',
            'PositiveSelfEntrepreneurial',
            'NegativeSelfEntrepreneurial',
            'OpenInnovation',
            'PositiveSelfInnovation',
            'NegativeSelfInnovation',
            'Total',
            'PerformanceAppraisalID',
            'Status',
            'ReviewByID',
        ],
    ]) ?>

</div>
