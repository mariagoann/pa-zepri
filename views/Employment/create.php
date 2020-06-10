<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Employment */

$this->title = 'Tambah Employment';
$this->params['breadcrumbs'][] = ['label' => 'Karyawan', 'url' => Url::to(['personalinfo/index'])];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employment-create">

    <?= $this->render('_form', [
        'model' => $model,
        'status'=>$status,
        'organization'=>$organization,
        'atasan'=>$atasan,
        'jobposition'=>$jobposition,
        'jobtitle'=>$jobtitle,
        'joblevel'=>$joblevel,
        'squad'=>$squad,
    ]) ?>

</div>
