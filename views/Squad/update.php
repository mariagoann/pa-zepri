<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Squad */

$this->title = 'Update Squad';
$this->params['breadcrumbs'][] = ['label' => 'Squad', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->SquadID, 'url' => ['view', 'id' => $model->SquadID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="squad-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
