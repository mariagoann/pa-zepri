<?php


use yii\helpers\Html;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Employment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employment-form">


    <?php $form = ActiveForm::begin([
        'action'=>Url::to(['saveEmployee']),
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

    <?= $form->field($model, 'EmployeeNumber', ['horizontalCssClasses' => ['wrapper' => 'col-md-6']])
            ->textInput(['maxlength' => true, 'placeholder'=>'Masukkan Nomor Karyawan'])
            ->label('Nomor Karyawan')
    ?>
    <?= $form->field($model, 'JoinDate',[
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

    <?= $form->field($model, 'EmployeeStatus',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($status, 'EmployeeStatusID', 'Name'),["prompt"=>"Pilih"])
                ->label("Status Karyawan") 
    ?>

    <?= $form->field($model, 'OrganizationID',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($organization, 'OrganizationID', 'Name'),["prompt"=>"Pilih"])
                ->label("Organization") 
    ?>
    <div class='row'>
        <div class = 'col-md-6'>
            <?= $form->field($model, 'JobPositionID',[
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
            <?= $form->field($model, 'AKA_JobPosition', ['horizontalCssClasses' => ['wrapper' => 'col-md-6']])
                ->textInput(['maxlength' => true, 'placeholder'=>'Masukkan Alias'])
                ->label(false)
            ?>
        </div>
    </div>

    <?= $form->field($model, 'JobTitleID',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($jobtitle, 'JobTitleID', 'JobTitleName'),["prompt"=>"Pilih"])
                ->label("Job Title") 
    ?>

    <?= $form->field($model, 'LevelID',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($joblevel, 'LevelID', 'LevelName'),["prompt"=>"Pilih"])
                ->label("Job Level") 
    ?>

    <?= $form->field($model, 'EmployeeSuperiorID',[    
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($atasan, 'EmployeeID', 'personal.FullName'),["prompt"=>"Pilih"])
                ->label("Atasan Langsung") 
    ?>

    <?= $form->field($model, 'SquadID',[
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
            <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Edit',
                 ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'id'=>'submit'
                 ]
            ) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

