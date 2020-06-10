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
                    ]),
                'options' => ['id' => 'personalinfo'],
                'active' => true
            ],
            [
                'label' => 'Data Karyawan',
                'content' => $this->render('_formEmployment', [
                        'modelEmployment' => $modelEmployment,
                        'statusEmployment'=>$statusEmployment,
                        'organization'=>$organization,
                        'atasan'=>$atasan,
                        'jobposition'=>$jobposition,
                        'jobtitle'=>$jobtitle,
                        'joblevel'=>$joblevel,
                        'squad'=>$squad,
                    ]),
                'options' => ['id' => 'datakaryawan'],
                'active' => false
            ],
        ],
    ]);
    ?>
</div>


