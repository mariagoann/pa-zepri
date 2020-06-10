<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Jobposition */

$this->title = 'Update Job Position';
$this->params['breadcrumbs'][] = ['label' => 'Job Position', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->JobPositionID, 'url' => ['view', 'id' => $model->JobPositionID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jobposition-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
