<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Jobtitle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jobtitle-form">

<?php $form = ActiveForm::begin([
    'layout' => 'horizontal', 
    'options' => ['enctype' => 'multipart/form-data'],
    'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-md-3',
            'offset' => 'col-md-offset-2',
            'wrapper' => 'col-md-8',
            'error' => '',
            'hint' => '',
        ],
    ],
]);?>

<?= $form->field($model, 'CodeJobTitle', ['horizontalCssClasses' => ['wrapper' => 'col-md-4']])
        ->textInput(['maxlength' => true, 'placeholder'=>'Masukkan Kode Job Title', 'required'=>true])
        ->label('Kode Job Title')
?>

<?= $form->field($model, 'JobTitleName', ['horizontalCssClasses' => ['wrapper' => 'col-md-4']])
        ->textInput(['maxlength' => true, 'placeholder'=>'Masukkan Nama Job Title', 'required'=>true]) 
        ->label('Nama Job Title')
?>

<div class="form-group">
    <div class="col-md-3"></div>
    <div class="col-md-3">
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Edit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

</div>
