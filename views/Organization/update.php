<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Organization */

$this->title = 'Update Organization';
$this->params['breadcrumbs'][] = ['label' => 'Organization', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->OrganizationID, 'url' => ['view', 'id' => $model->OrganizationID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="organization-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
