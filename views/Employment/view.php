<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Employment */

$this->title = $model->EmployeeID;
$this->params['breadcrumbs'][] = ['label' => 'Employments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="employment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->EmployeeID], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->EmployeeID], [
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
            'EmployeeID',
            'PersonalID',
            'JoinDate',
            'EmployeeStatus',
            'OrganizationID',
            'JobPositionID',
            'AKA_JobPosition',
            'JobTitleID',
            'LevelID',
            'EmployeeSuperiorID',
            'SquadID',
            'EmployeeNumber',
        ],
    ]) ?>

</div>
