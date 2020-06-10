<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Joblevel */

$this->title = 'Tambah Job Level';
$this->params['breadcrumbs'][] = ['label' => 'Job Level', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['header'] = $this->title;
?>
<div class="joblevel-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
