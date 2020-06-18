<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Personalinfo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="personalinfo-form">

<?php 
    $_url = Url::to(['save']);
    if(!$model->isNewRecord){
        $_url.="&id=".$_GET['id'];
    }
    $form = ActiveForm::begin([
        'action'=>$_url,
        'id'=>'personalinfoform',
        'layout' => 'horizontal', 
        'options' => ['enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-md-3',
                'offset' => 'col-md-offset-0',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]);?>

    <?php
       
        if(!$model->isNewRecord){
            echo "<input type='hidden' name='mode' value=1 />";
        }else{
            echo "<input type='hidden' name='mode' value=0 />";
        }
    ?>
    <?= $form->field($model, 'FullName', ['horizontalCssClasses' => ['wrapper' => 'col-md-6']])
            ->textInput(['maxlength' => true, 'placeholder'=>'Masukkan Nama Lengkap'])
            ->label('Nama Lengkap')
    ?>
    <div class='row'>
        <div class = 'col-md-6'>
            <?= $form->field($model, 'IdentityType',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-6',
                    'label' => 'col-md-6',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($identity, 'IdentityTypeID', 'Name'),["prompt"=>"Pilih"])
                ->label("Kartu Identitas") 
            ?>
        </div>
        <div class='col-md-3'>
            <?= $form->field($model, 'IdentityNumber', [
                    'horizontalCssClasses' => [
                        'wrapper' => 'col-md-12',
                    ]
                ])->textInput(['maxlength' => true, 'placeholder'=>'Masukkan Nomor Identitas'])
                    ->label(false)
            ?>
        </div>
        <div class='col-md-3'>
            <?= $form->field($model, 'IdentityExpiryDate',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-12',
                ],
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
                        'options'=>['size'=>27,'changeMonth'=>'true','class'=>'form-control', 'placeholder'=>'Tanggal Berlaku']
                    ])->label(false)
            ?>
        </div>
    </div>

    <div class='row'>
        <div class = 'col-md-6'>
        <?= $form->field($model, 'PlaceOfBirth', [
                    'horizontalCssClasses' => [
                        'wrapper' => 'col-md-6',
                        'label' => 'col-md-6',
                    ]
                ])->textInput(['maxlength' => true, 'placeholder'=>'Masukkan Tempat Lahir'])
                    ->label("Tempat & Tanggal Lahir")
            ?>
        </div>
        <div class='col-md-6'>
            <?= $form->field($model, 'DateOfBirth',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-6',
                ],
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
                        'options'=>['size'=>27,'changeMonth'=>'true','class'=>'form-control', 'placeholder'=>'Tanggal Lahir']
                    ])->label(false)
            ?>
        </div>
    </div>

    <?= $form->field($model, 'Status',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($status, 'StatusPersonalID', 'Name'),["prompt"=>"Pilih"])
                ->label("Status") 
    ?>
    <?=$form->field($model, 'Gender')->label(true)->inline()->radioList($gender)->label("Jenis Kelamin");?>

    <?= $form->field($model, 'Religion',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($religion, 'ReligionID', 'Name'),["prompt"=>"Pilih"])
                ->label("Agama") 
    ?>

    <?= $form->field($model, 'PhoneNumber', ['horizontalCssClasses' => ['wrapper' => 'col-md-3']])
            ->textInput(['maxlength' => true, 'placeholder'=>'Masukkan No HP'])
            ->label('No HP')
    ?>

    <?= $form->field($model, 'Address', ['horizontalCssClasses' => ['wrapper' => 'col-md-6']])
            ->textarea(['rows' => 3]) 
            ->label('Alamat')
    ?>

    <?= $form->field($model, 'Email', ['horizontalCssClasses' => ['wrapper' => 'col-md-4']])
            ->textInput(['maxlength' => true, 'placeholder'=>'Masukkan Email'])
            ->label('Email')
    ?>

    <?php
        if(!$model->isNewRecord && $model->UserID!=null){
         echo $form->field($model, 'username', ['horizontalCssClasses' => ['wrapper' => 'col-md-3']])
            ->textInput(['placeholder'=>'Masukkan Username', 'value'=>$model->user->username])
            ->label('Username');

        echo $form->field($model, 'password', ['horizontalCssClasses' => ['wrapper' => 'col-md-3']])
                ->passwordInput(['placeholder'=>'Masukkan Password', 'value'=>$model->user->password])
                ->label('Password');
        }else{


            echo $form->field($model, 'username', ['horizontalCssClasses' => ['wrapper' => 'col-md-3']])
            ->textInput(['placeholder'=>'Masukkan Username'])
            ->label('Username');

            echo $form->field($model, 'password', ['horizontalCssClasses' => ['wrapper' => 'col-md-3']])
            ->passwordInput(['placeholder'=>'Masukkan Password'])
            ->label('Password');
        }
    ?>



    <div class="form-group">
        <div class="col-md-3"></div>
        <div class="col-md-3">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan & Lanjut' : 'Edit',
                 ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'id'=>'submit'
                 ]
            ) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
jQuery(document).ready(function($) {
    $('#personalinfoform').on('beforeSubmit', function(e) {
        var form = $(this);
        var formData = form.serialize();
        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            data: formData,
            success: function (response) {
                alert(response.data.message);
                $("#personalinfoform :input").prop('readonly', true);
                document.getElementById("submit").disabled = true; 
                $('.nav-pills a[href="#datakaryawan"]').tab('show');
            },
            error: function () {
                alert("Something went wrong");
            }
        });
    }).on('submit', function(e){
        e.preventDefault();
    });
});

JS;
$this->registerJs($script);
?>


