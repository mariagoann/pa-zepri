<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Periode */

$this->title = 'Update Periode';
$this->params['breadcrumbs'][] = ['label' => 'Periode', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->PeriodeID, 'url' => ['view', 'id' => $model->PeriodeID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="periode-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
