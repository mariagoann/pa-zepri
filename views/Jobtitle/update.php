<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Jobtitle */

$this->title = 'Update Job Title';
$this->params['breadcrumbs'][] = ['label' => 'Job Title', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->JobTitleID, 'url' => ['view', 'id' => $model->JobTitleID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jobtitle-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
