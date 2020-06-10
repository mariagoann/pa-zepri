<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Employment */

$this->title = 'Update Employment: ' . $model->EmployeeID;
$this->params['breadcrumbs'][] = ['label' => 'Employments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->EmployeeID, 'url' => ['view', 'id' => $model->EmployeeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
