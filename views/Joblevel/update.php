<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Joblevel */

$this->title = 'Update Job Level';
$this->params['breadcrumbs'][] = ['label' => 'Joblevels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->LevelID, 'url' => ['view', 'id' => $model->LevelID]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="joblevel-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
