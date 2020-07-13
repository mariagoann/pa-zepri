<?php


use yii\helpers\Html;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use yii\helpers\Url;
$urlindex = Url::to(['index']);
/* @var $this yii\web\View */
/* @var $modelEmployment app\modelEmployments\Employment */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="employment-form">


    <?php 
        $_url = Url::to(['saveemployee']);
        if(!$model->isNewRecord){
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
            ->textInput(['maxlength' => true, 'placeholder'=>'Masukkan Nomor Karyawan', 'disabled'=>$readonly])
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
                        'yearRange'=>"-100:2030",
                    ],
                'options'=>['size'=>27,'changeMonth'=>'true','class'=>'form-control', 'placeholder'=>'Join Date', 'disabled'=>$readonly]
            ])->label('Join Date')
    ?>

    <?= $form->field($modelEmployment, 'EmployeeStatus',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($statusEmployment, 'EmployeeStatusID', 'Name'),["prompt"=>"Pilih", 'disabled'=>$readonly])
                ->label("Status Karyawan") 
    ?>

    <?= $form->field($modelEmployment, 'OrganizationID',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($organization, 'OrganizationID', 'OrganizationName'),["prompt"=>"Pilih",'disabled'=>$readonly])
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
                                ArrayHelper::map($jobposition, 'JobPositionID', 'JobPositionName'),["prompt"=>"Pilih",'disabled'=>$readonly])
                        ->label("Job Position") 
            ?>
        </div>
        <div class=col-md-6>
            <?= $form->field($modelEmployment, 'AKA_JobPosition', ['horizontalCssClasses' => ['wrapper' => 'col-md-6']])
                ->textInput(['maxlength' => true, 'placeholder'=>'Masukkan Alias','disabled'=>$readonly])
                ->label(false)
            ?>
        </div>
    </div>

    <?= $form->field($modelEmployment, 'JobTitleID',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($jobtitle, 'JobTitleID', 'JobTitleName'),["prompt"=>"Pilih",'disabled'=>$readonly])
                ->label("Job Title") 
    ?>

    <?= $form->field($modelEmployment, 'LevelID',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($joblevel, 'LevelID', 'LevelName'),["prompt"=>"Pilih",'disabled'=>$readonly])
                ->label("Job Level") 
    ?>

    <?= $form->field($modelEmployment, 'EmployeeSuperiorID',[    
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-3',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($atasan, 'EmployeeID', 'personal.FullName'),["prompt"=>"Pilih",'disabled'=>$readonly])
                ->label("Atasan Langsung") 
    ?>

    <?= $form->field($modelEmployment, 'SquadID',[
                'horizontalCssClasses' => [
                    'wrapper' => 'col-md-2',
                    ]
                ])->dropDownList(
                        ArrayHelper::map($squad, 'SquadID', 'SquadName'),["prompt"=>"Pilih",'disabled'=>$readonly])
                ->label("Squad") 
    ?>
    

    <div class="form-group">
        <div class="col-md-3"></div>
        <?php
            if(!$readonly){
        ?>
            <div class="col-md-3">
                <?= Html::submitButton($modelEmployment->isNewRecord ? 'Tambah' : 'Simpan',
                    ['class' => $modelEmployment->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                        'id'=>'submitEmployment',
                    ]
                ) ?>
                <button type="button" class="btn btn-danger" id='batal2'>Cancel</button>
            </div>
        <?php
            }else{
        ?>
        <div class="col-md-3">
            <?= Html::submitButton($modelEmployment->isNewRecord ? 'Tambah' : 'Simpan',
                ['class' => $modelEmployment->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                    'id'=>'submitEmployment',
                    'disabled'=>true
                ]
            ) ?>
            <button type="button" class="btn btn-danger" id='batal2', disabled='true'>Cancel</button>
        </div>
        <?php
            }
        ?>
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
document.getElementById("batal2").onclick = function(){
    var url = "$urlindex";
    window.location.href=url;
};
JS;
$this->registerJs($script);
?>

