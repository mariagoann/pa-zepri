<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Paparameter */

$this->title = 'Update: '.$judul;
$this->params['breadcrumbs'][] = ['label' => 'Daftar PA', 'url' => ['evaluates']];
$this->params['breadcrumbs'][] = 'Update '.$this->title;
?>
<div class="paparameter-update">
    <?= $this->render('_form', [
            'model' => $model,
            'prfmaprsl'=>$prfmaprsl,
            'employee'=>$employee,
    ]) ?>

</div>
