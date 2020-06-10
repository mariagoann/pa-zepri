<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Periode */

$this->title = 'Tambah Periode';
$this->params['breadcrumbs'][] = ['label' => 'Periode', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="periode-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
