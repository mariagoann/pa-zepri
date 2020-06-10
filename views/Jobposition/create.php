<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Jobposition */

$this->title = 'Tambah Job Position';
$this->params['breadcrumbs'][] = ['label' => 'Job Position', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jobposition-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
