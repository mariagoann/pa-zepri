<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Periode */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periode-form">

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

    <?= $form->field($model, 'Start',[
            'horizontalCssClasses' => ['wrapper' => 'col-md-4',],
            'inputTemplate' => '<div class="input-group"><span class="input-group-addon">
                                <span class="   glyphicon glyphicon-calendar"></span>
                                </span>{input}</div>',
                ])->widget(DatePicker::className(),
                [
                    'dateFormat' => 'yyyy-MM-dd',
                    'clientOptions'=>
                        [
                            'changeMonth'=>'true',
                            'changeYear'=>'true',
                            'yearRange'=>"-25:date('Y')",
                        ],
                    'options'=>['size'=>27,'changeMonth'=>'true','class'=>'form-control']
    ])->label('Tanggal Awal Periode') ?>

    <?= $form->field($model, 'End',[
            'horizontalCssClasses' => ['wrapper' => 'col-md-4',],
            'inputTemplate' => '<div class="input-group"><span class="input-group-addon">
                                <span class="   glyphicon glyphicon-calendar"></span>
                                </span>{input}</div>',
                ])->widget(DatePicker::className(),
                [
                    'dateFormat' => 'yyyy-MM-dd',
                    'clientOptions'=>
                        [
                            'changeMonth'=>'true',
                            'changeYear'=>'true',
                            'yearRange'=>"-25:date('Y')",
                        ],
                    'options'=>['size'=>27,'changeMonth'=>'true','class'=>'form-control']
    ])->label('Tanggal Akhir Periode') ?>

    <?= $form->field($model, 'LastModified',[
            'horizontalCssClasses' => ['wrapper' => 'col-md-4',],
            'inputTemplate' => '<div class="input-group"><span class="input-group-addon">
                                <span class="   glyphicon glyphicon-calendar"></span>
                                </span>{input}</div>',
                ])->widget(DatePicker::className(),
                [
                    'dateFormat' => 'yyyy-MM-dd',
                    'clientOptions'=>
                        [
                            'changeMonth'=>'true',
                            'changeYear'=>'true',
                            'yearRange'=>"-25:date('Y')",
                        ],
                    'options'=>['size'=>27,'changeMonth'=>'true','class'=>'form-control']
    ])->label('Tanggal Akhir Penilaian') ?>

    <?=$form->field($model, 'Status')->label(true)->inline()->radioList($active)->label("Status");?>
    <div class="form-group">
        <div class="col-md-3"></div>
        <div class="col-md-3">
            <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Edit', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
