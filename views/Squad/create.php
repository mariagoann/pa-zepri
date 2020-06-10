<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Squad */

$this->title = 'Tambah Squad';
$this->params['breadcrumbs'][] = ['label' => 'Squad', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="squad-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
