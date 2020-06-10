<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Paparameter */

$this->title = $judul;
$this->params['breadcrumbs'][] = ['label' => 'Daftar PA', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paparameter-create">
    <?= $this->render('_form', [
            'model' => $model,
            'prfmaprsl'=>$prfmaprsl,
            'employee'=>$employee,
            'value'=>$value
    ]) ?>

</div>
