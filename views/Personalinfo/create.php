<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Personalinfo */

$this->title = 'Tambah Karyawan';
$this->params['breadcrumbs'][] = ['label' => 'Karyawan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="personalinfo-create">
    <?= Tabs::widget([
        'navType'=>'nav-pills',
        'items' => [
            [
                'label' => 'Personal Info',
                'content' => $this->render('_form', [
                        'model' => $model,
                        'identity'=>$identity,
                        'gender'=>$gender,
                        'religion'=>$religion,
                        'status'=>$status,
                        'readonly'=>$readonly
                    ]),
                'options' => ['id' => 'personalinfo'],
                'active' => true
            ],
            [
                'label' => 'Data Karyawan',
                'content' => $this->render('_formEmployment', [
                        'model'=>$model,
                        'modelEmployment' => $modelEmployment,
                        'statusEmployment'=>$statusEmployment,
                        'organization'=>$organization,
                        'atasan'=>$atasan,
                        'jobposition'=>$jobposition,
                        'jobtitle'=>$jobtitle,
                        'joblevel'=>$joblevel,
                        'squad'=>$squad,
                        'readonly'=>$readonly
                    ]),
                'options' => ['id' => 'datakaryawan'],
                'active' => false
            ],
        ],
    ]);
    ?>
</div>


