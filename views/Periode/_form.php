<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\Url;
use yii\widgets\Pjax;
$urlindex = Url::to(['index']);
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
                            'yearRange'=>"-20:2030",
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
                            'yearRange'=>"-20:2030",
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
                            'yearRange'=>"-20:2030",
                        ],
                    'options'=>['size'=>27,'changeMonth'=>'true','class'=>'form-control']
    ])->label('Tanggal Akhir Penilaian') ?>

    <?=$form->field($model, 'Status')->label(true)->inline()->radioList($active)->label("Status");?>
    <div class="form-group">
        <div class="col-md-3"></div>
        <div class="col-md-3">
        <?php
            $button = Html::submitButton('Tambah', ['class' =>'btn btn-success' ]);
            if(!$model->isNewRecord){
                $button = Html::submitButton('Simpan', ['class' =>'btn btn-primary', 
                    'data' => [
                    'confirm' => 'Are you sure want to Update this item?'
                    ] 
                ]);
            }
            echo $button;
        ?>
        <!-- <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?> -->
        <button type="button" class="btn btn-danger" id='batal'>Cancel</button>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
document.getElementById("batal").onclick = function(){
    var url = "$urlindex";
    window.location.href=url;
};
JS;
$this->registerJs($script);
?>
