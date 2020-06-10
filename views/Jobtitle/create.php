<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Jobtitle */

$this->title = 'Tambah Job Title';
$this->params['breadcrumbs'][] = ['label' => 'Job Title', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jobtitle-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
