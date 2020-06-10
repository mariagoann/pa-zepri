<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Organization */

$this->title = 'Tambah Organization';
$this->params['breadcrumbs'][] = ['label' => 'Organization', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
