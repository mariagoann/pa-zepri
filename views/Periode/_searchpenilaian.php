<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\PersonalinfoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personalinfo-search">

    <?php $form = ActiveForm::begin([
        'layout'=>'horizontal',
        // 'method' => 'get',
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'offset' => 'col-md-offset-0',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>
    <div class='row'>
        <div class='col-md-6'>
            <?= $form->field($model, 'field', [
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-12',
                ]])
                ->label(false)
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
