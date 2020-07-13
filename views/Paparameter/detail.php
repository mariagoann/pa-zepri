<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Paparameter */
/* @var $form yii\widgets\ActiveForm */
$periodePenilaian = Yii::$app->formatter->format($prfmaprsl->periode->Start, 'date')." - ".
Yii::$app->formatter->format($prfmaprsl->periode->End, 'date' );
$this->title = 'Detail Parameter Penilaian';
$this->params['breadcrumbs'][] = ['label' => 'Hasil Penilaian', 'url' => ['/periode/detail-nilai','id'=>$idc]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="paparameter-form">
    <div class ='row'>
        <div class=col-md-1></div>
        <div class ='col-md-10'>
            <table class='table table-striped table-bordered'>
                <tbody>
                    <tr>
                        <td><b>Periode Penilaian</tb></td>
                        <td><?php echo $periodePenilaian?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Nomor Karyawan</tb></td>
                        <td><?php echo $employee->EmployeeNumber;?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Nama Karyawan</tb></td>
                        <td><?php echo $employee->personal->FullName;?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Join Date</tb></td>
                        <td><?php echo Yii::$app->formatter->format($employee->JoinDate, 'date');?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Job Position</tb></td>
                        <td><?php echo $employee->jobPosition->JobPositionName;?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Squad</tb></td>
                        <td><?php echo $employee->squad!=null?$employee->squad->SquadName:'-';?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php 
        $form = ActiveForm::begin([
            'id'=>'paparameterform',
            'layout' => 'horizontal', 
            'options' => ['enctype' => 'multipart/form-data'],
            'fieldConfig' => [
                'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
                'horizontalCssClasses' => [
                ],
            ],
        ]);
    ?>
    <?php
        echo "<input type='hidden' name='mode' id='mode' value=0 />";
        $type = explode('-', $model->TypePA);
        if($type[0]=="self" || $type[0]=="superior"){
    ?>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <p><b>Pertanyaan Kinerja Karyawan:</b></p>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'PositiveContribution', ['horizontalCssClasses' => 
                                [
                                    'wrapper'=>'col-md-7',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->textarea(['rows' => 4,'readonly'=>true]) 
                ->label('Sebutkan dan berikan penjelasan terkait kontribusi positif 
                        yang tim anda berikan dari '.$periodePenilaian.'!')
            ?>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'SelfImprovement', ['horizontalCssClasses' => 
                                    [
                                    'wrapper' => 'col-md-7',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->textarea(['rows' => 4,'readonly'=>true]) 
                ->label('Sebutkan dan berikan penjelasan mengenai hal-hal dalam konteks 
                        pekerjaan yang perlu diperbaiki dari diri tim anda!')
            ?>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'EmployeePerformanceScore', ['horizontalCssClasses' => 
                                [
                                    'wrapper'=>'col-md-3',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->inline()
                ->textInput(['placeholder'=>'Masukkan Nilai', 'type'=>'number', 'max'=>5, 'min'=>0, 'step'=>0.01, 'readonly'=>true])
                ->label("Skor Kinerja Karayawan");
            ?>
        </div>
    </div>
    <?php
        }
    ?>

    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <p><b>Pertanyaan ASPIRASI KARYAWAN:</b></p>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'TeamImprovement', ['horizontalCssClasses' => 
                                    [
                                    'wrapper'=>'col-md-7',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->textarea(['rows' => 4,'readonly'=>true]) 
                ->label('Mohon berikan usulan terkait program 
                        pengembangan yang tim anda butuhkan di periode mendatang!')
            ?>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'Aspirasi', ['horizontalCssClasses' => 
                                    [
                                    'wrapper'=>'col-md-7',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->textarea(['rows' => 4,'readonly'=>true]) 
                ->label('Apabila ada, mohon tuliskan aspirasi, issue, kendala, 
                        atau hal lain yang dirasakan oleh tim anda dan perlu support atau diperbaiki di periode selanjutnya di bagian ini.')
            ?>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <p><b>Pertanyaan CORE VALUES:</b></p>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'AGILE', ['horizontalCssClasses' => 
                                [
                                    'wrapper'=>'col-md-3',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->inline()
                ->textInput(['placeholder'=>'Masukkan Nilai', 'type'=>'number', 'max'=>5, 'min'=>0, 'step'=>0.1,'readonly'=>true])
                ->label('AGILE : Kita gercep (gerak cepat), dengan menerapkan organisasi yang ramping, 
                            siklus belajar cepat, di lingkungan yang berorientasikan data. ')
            ?>
        </div>
    </div>

    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'PositifSelfAgile', ['horizontalCssClasses' => 
                                    [
                                    'wrapper'=>'col-md-7',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->textarea(['rows' => 4,'readonly'=>true]) 
                ->label('Mohon berikan contoh perilaku tim anda yang sesuai dengan nilai Agile perusahaan!')
            ?>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'NegativeSelfAgile', ['horizontalCssClasses' => 
                                    [
                                    'wrapper'=>'col-md-7',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->textarea(['rows' => 4,'readonly'=>true]) 
                ->label('Mohon berikan contoh perilaku tim anda yang belum sesuai dengan nilai Agile perusahaan!')
            ?>
        </div>
    </div>

    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'IMPACT', ['horizontalCssClasses' => 
                                [
                                    'wrapper'=>'col-md-3',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->inline()
                ->textInput(['placeholder'=>'Masukkan Nilai', 'type'=>'number', 'max'=>5, 'min'=>0, 'step'=>0.1,'readonly'=>true])
                ->label('IMPACT: Kita mengembangkan kemampuan untuk bisa memberdayakan orang lain - termasuk anggota tim dan pelanggan, 
                        sehingga menciptakan dampak positif sebanyak mungkin bagi masyarakat.')
            ?>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'PositiveSelfImpact', ['horizontalCssClasses' => 
                                    [
                                    'wrapper'=>'col-md-7',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->textarea(['rows' => 4,'readonly'=>true]) 
                ->label('Mohon berikan contoh perilaku tim anda yang sesuai dengan nilai Impact perusahaan!')
            ?>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'NegativeSelfImpact', ['horizontalCssClasses' => 
                                    [
                                    'wrapper'=>'col-md-7',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->textarea(['rows' => 4,'readonly'=>true]) 
                ->label('Mohon berikan contoh perilaku anda yang belum sesuai dengan nilai Impact perusahaan!')
            ?>
        </div>
    </div>

    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'UDPE', ['horizontalCssClasses' => 
                                [
                                    'wrapper'=>'col-md-3',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->inline()
                ->textInput(['placeholder'=>'Masukkan Nilai', 'type'=>'number', 'max'=>5, 'min'=>0, 'step'=>0.1,'readonly'=>true])
                ->label('User-driven Performance Excellence : Pelanggan selalu di hati kita. 
                        Kemajuan mereka adalah kemajuan kita juga. Kita membantu pelanggan meraih hasil terbaik mereka dengan mengerahkan 
                        kemampuan terbaik dan kinerja yang unggul.')
            ?>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'PositiveSelfUDPE', ['horizontalCssClasses' => 
                                    [
                                    'wrapper'=>'col-md-7',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->textarea(['rows' => 4,'readonly'=>true]) 
                ->label('Mohon berikan contoh perilaku tim anda yang sesuai dengan nilai User-driven Performance Excellence perusahaan!')
            ?>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'NegativeSelfUDPE', ['horizontalCssClasses' => 
                                    [
                                    'wrapper'=>'col-md-7',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->textarea(['rows' => 4,'readonly'=>true]) 
                ->label('Mohon berikan contoh perilaku tim anda yang belum sesuai dengan nilai User-driven Performance Excellence perusahaan!')
            ?>
        </div>
    </div>

    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'Entrepreneurial', ['horizontalCssClasses' => 
                                [
                                    'wrapper'=>'col-md-3',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->inline()
                ->textInput(['placeholder'=>'Masukkan Nilai', 'type'=>'number', 'max'=>5, 'min'=>0, 'step'=>0.1,'readonly'=>true])
                ->label('Entrepreneurial : Kita memastikan pertumbuhan perusahaan dimotori oleh semangat bereksplorasi dan mentalitas kewirausahaan. 
                        Selalu ada ruang untuk bermimpi, bereksperimen dengan berani, dan membina rasa suka cita pada reka-cipta.')
            ?>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'PositiveSelfEntrepreneurial', ['horizontalCssClasses' => 
                                    [
                                    'wrapper'=>'col-md-7',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->textarea(['rows' => 4,'readonly'=>true]) 
                ->label('Mohon berikan contoh perilaku tim anda yang sesuai dengan nilai Entrepreneurial perusahaan!')
            ?>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'NegativeSelfEntrepreneurial', ['horizontalCssClasses' => 
                                    [
                                    'wrapper'=>'col-md-7',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->textarea(['rows' => 4,'readonly'=>true]) 
                ->label('Mohon berikan contoh perilaku tim anda yang belum sesuai dengan nilai Entrepreneurial perusahaan!')
            ?>
        </div>
    </div>

    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'OpenInnovation', ['horizontalCssClasses' => 
                                [
                                    'wrapper'=>'col-md-3',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->inline()
                ->textInput(['placeholder'=>'Masukkan Nilai', 'type'=>'number', 'max'=>5, 'min'=>0, 'step'=>0.1,'readonly'=>true])
                ->label('Open Innovation : Kita berinovasi melalui kreatifitas yang dirangkul dalam sikap yang serba terbuka; 
                        keterbukaan pola pikir, terbuka dalam menerima tanggapan, dan membuat lingkungan kerja yang
                         membudayakan kelugasan berbicara.')
            ?>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'PositiveSelfInnovation', ['horizontalCssClasses' => 
                                    [
                                    'wrapper'=>'col-md-7',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->textarea(['rows' => 4,'readonly'=>true]) 
                ->label('Mohon berikan contoh perilaku tim anda yang sesuai dengan nilai Open Innovation perusahaan!')
            ?>
        </div>
    </div>
    <div class='row'>
        <div class=col-md-1></div>
        <div class='col-md-10'>
            <?= $form->field($model, 'NegativeSelfInnovation', ['horizontalCssClasses' => 
                                    [
                                    'wrapper'=>'col-md-7',
                                    'label'=>'col-md-5'
                                ]
                            ])
                ->textarea(['rows' => 4,'readonly'=>true]) 
                ->label('Mohon berikan contoh perilaku tim anda yang belum sesuai dengan nilai Open Innovation perusahaan!')
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>