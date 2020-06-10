<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $model app\models\Personalinfo */

$this->title = $model->FullName;
$this->params['breadcrumbs'][] = ['label' => 'Karyawan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="personalinfo-view">

    <?php
        echo Tabs::widget([
            'navType'=>'nav-pills',
            'items' => [
                [
                    'label' => 'Personal Info',
                    'content' => DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute'=>"Nama Lengkap",
                                "value"=>$model->FullName,
                            ],
                            [
                                'attribute'=>"Kartu Identitas",
                                "value"=>$model->identityType->Name,
                            ],
                            [
                                'attribute'=>"Tipe Kartu Identitas",
                                "value"=>$model->IdentityNumber,
                            ],
                            [
                                'attribute'=>"Tanggal Berlaku",
                                "value"=>Yii::$app->formatter->format($model->IdentityExpiryDate, 'date' ),
                            ],                
                            [
                                'attribute'=>"Tempat dan Tanggal Lahir",
                                "value"=>$model->PlaceOfBirth." / ".Yii::$app->formatter->format($model->DateOfBirth, 'date' ),
                            ],
                            [
                                'attribute'=>"Status",
                                "value"=>$model->status->Name,
                            ],  
                            [
                                'attribute'=>"Gender",
                                "value"=>$model->gender->Name,
                            ],  
                            [
                                'attribute'=>"Religion",
                                "value"=>$model->religion->Name,
                            ], 
                            [
                                'attribute'=>"Phone Number",
                                "value"=>$model->PhoneNumber,
                            ],
                            [
                                'attribute'=>"Address",
                                "value"=>$model->Address,
                            ],
                            'Email:email',
                            'UserID',
                        ],
                    ]),
                    'options' => ['id' => 'personalinfo'],
                    'active' => true
                ],
                [
                    'label' => 'Data Karyawan',
                    'content' => DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute'=>"Nomor Karyawan",
                                "value"=>$model->employments==null?"-":$model->employments->EmployeeNumber,
                            ],
                            [
                                'attribute'=>"Join Date",
                                "value"=>$model->employments==null?"-":Yii::$app->formatter->format($model->employments->JoinDate, 'date'),
                            ],
                            [
                                'attribute'=>"Status Karyawan",
                                "value"=>$model->employments==null?"-":$model->employments->employeeStatus->Name,
                            ],
                            [
                                'attribute'=>"Organization",
                                "value"=>$organization,
                            ],
                            [
                                'attribute'=>"Job Position",
                                "value"=>$jobPosition,
                            ],
                            [
                                'attribute'=>"AKA Job Position",
                                "value"=>$model->employments==null?"-":$model->employments->AKA_JobPosition,
                            ],
                            [
                                'attribute'=>"Job Title",
                                "value"=>$jobTitle,
                            ],
                            [
                                'attribute'=>"Job Level",
                                "value"=>$level,
                            ],
                            [
                                'attribute'=>"Atasan Langsung",
                                "value"=>$atasan,
                            ],
                            [
                                'attribute'=>"Squad",
                                "value"=>$squad,
                            ],
                        ],
                    ]),
                    'options' => ['id' => 'datakaryawan'],
                    'active' => false
                ],
            ],
        ]);
    ?>

</div>
