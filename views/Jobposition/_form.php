<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Jobposition */
/* @var $form yii\widgets\ActiveForm */
$urlindex = Url::to(['index']);
?>

<div class="jobposition-form">


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

    <?= $form->field($model, 'CodeJobPosition', ['horizontalCssClasses' => ['wrapper' => 'col-md-4']])
            ->textInput(['maxlength' => true, 'placeholder'=>'Masukkan Job Position', 'required'=>true])
            ->label('Kode Job Position')
    ?>

    <?= $form->field($model, 'JobPositionName', ['horizontalCssClasses' => ['wrapper' => 'col-md-4']])
            ->textInput(['maxlength' => true, 'placeholder'=>'Masukkan Nama Job Position', 'required'=>true]) 
            ->label('Nama Job Position')
    ?>

    <?= $form->field($model, 'Level', ['horizontalCssClasses' => ['wrapper' => 'col-md-4']])
            ->textInput(['tyoe' => 'number', 'placeholder'=>'Masukkan Level Job Position', 'required'=>true]) 
            ->label('Level')
    ?>

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
