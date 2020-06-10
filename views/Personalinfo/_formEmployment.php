<?php


use yii\helpers\Html;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $modelEmployment app\modelEmployments\Employment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employment-form">


    <?php 
        $_url = Url::to(['saveemployee']);
        if(!$modelEmployment->isNewRecord){
            $_url.="&id=".$_GET['id'];
        }
        $form = ActiveForm::begin([
        'action'=>$_url,
        'id'=>'employmentform',
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
       
       if(!$modelEmployment->isNewRecord){
        echo "<input type='hidden' name='mode' value=1 />";
        }else{
            echo "<input type='hidden' name='mode' value=0 />";
        }
    ?>
    <?= $form->field($modelEmployment, 'EmployeeNumber', ['horizontalCssClasses' => ['wrapper' => 'col-md-6']])
            ->textInput(['maxlength' => true, 'placeholder'=>'Masukkan Nomor Karyawan'])
            ->label('Nomor Karyawan')
    ?>
    <?= $form->field($modelEmployment, 'JoinDate',[
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
                'options'=>['size'=>27,'changeMonth'=>'true','class'=>'form-control', 'placeholder'=>'Join Date']
            ])->label('Join Date')
    ?>

    <?= $form->field($modelEmployment, 'EmployeeStatus',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($statusEmployment, 'EmployeeStatusID', 'Name'),["prompt"=>"Pilih"])
                ->label("Status Karyawan") 
    ?>

    <?= $form->field($modelEmployment, 'OrganizationID',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($organization, 'OrganizationID', 'OrganizationName'),["prompt"=>"Pilih"])
                ->label("Organization") 
    ?>
    <div class='row'>
        <div class = 'col-md-6'>
            <?= $form->field($modelEmployment, 'JobPositionID',[
                        'horizontalCssClasses' => [
                            'wrapper' => 'col-md-6',
                            'label'=>'col-md-6'
                            ]
                        ])->dropDownList(
                                ArrayHelper::map($jobposition, 'JobPositionID', 'JobPositionName'),["prompt"=>"Pilih"])
                        ->label("Job Position") 
            ?>
        </div>
        <div class=col-md-6>
            <?= $form->field($modelEmployment, 'AKA_JobPosition', ['horizontalCssClasses' => ['wrapper' => 'col-md-6']])
                ->textInput(['maxlength' => true, 'placeholder'=>'Masukkan Alias'])
                ->label(false)
            ?>
        </div>
    </div>

    <?= $form->field($modelEmployment, 'JobTitleID',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($jobtitle, 'JobTitleID', 'JobTitleName'),["prompt"=>"Pilih"])
                ->label("Job Title") 
    ?>

    <?= $form->field($modelEmployment, 'LevelID',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($joblevel, 'LevelID', 'LevelName'),["prompt"=>"Pilih"])
                ->label("Job Level") 
    ?>

    <?= $form->field($modelEmployment, 'EmployeeSuperiorID',[    
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-3',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($atasan, 'EmployeeID', 'personal.FullName'),["prompt"=>"Pilih"])
                ->label("Atasan Langsung") 
    ?>

    <?= $form->field($modelEmployment, 'SquadID',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($squad, 'SquadID', 'SquadName'),["prompt"=>"Pilih"])
                ->label("Squad") 
    ?>

    <div class="form-group">
        <div class="col-md-3"></div>
        <div class="col-md-3">
            <?= Html::submitButton($modelEmployment->isNewRecord ? 'Tambah' : 'Edit',
                 ['class' => $modelEmployment->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'id'=>'submitEmployment'
                 ]
            ) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
jQuery(document).ready(function($) {
    $('#employmentform').on('beforeSubmit', function(e) {
        var form = $(this);
        var formData = form.serialize();
        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            data: formData,
            success: function (response) {
                console.log('success')
                alert(response.data.message);
                window.location.href = response.data.url;
            },
            error: function () {
                alert("Something went wrong");
            }
        });
    }).on('submitEmployment', function(e){
        e.preventDefault();
    });
});

JS;
$this->registerJs($script);
?>

