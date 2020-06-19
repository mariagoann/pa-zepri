<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonalinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Karyawan yang Harus Anda Nilai';
$this->params['breadcrumbs'][] = ['label' => 'Daftar Periode Penilaian', 'url' => ['evaluates',]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="generate-index">
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>


<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<div class='row'>
    <div class='col-md-2'>
        <p><h4>Periode Penilaian</h4></p>
    </div>
    <div class='col-md-3'>
        <p>
            <h4><?php echo Yii::$app->formatter->format($periode->Start, 'date')." - ".Yii::$app->formatter->format($periode->End, 'date' )?></h4>
        </p>
    </div>
</div>

<?php
    if($employee!=null){
?>
    <div class='row'>
        <div class ='col-md-6'>
            <table class='table table-bordered table-striped'>
                <tbody>
                    <tr>
                        <td><b>Self Performance Appraisal</b></td>
                        <td><?php echo $employee['name'];?></td>
                        <td><?php 
                                if(!$employee['status']){
                                    echo Html::a('Nilai', ['nilai', 'by'=>$employee['by'],
                                                                    'id'=>$employee['id'],
                                                                    'type'=>$employee['type']]);
                                }else{
                                    echo Html::a('Ubah', ['ubahnilai', 'by'=>$employee['by'],
                                                                        'id'=>$employee['id'],
                                                                        'type'=>$employee['type']]);
                                }
                          ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class='row'>
        <div class ='col-md-6'>
            <table class='table table-bordered table-striped'>
                <tbody>
                    <?php
                        if($peers!=null){
                            $i=1;
                            foreach ($peers as $key => $value) {
                                echo "<tr>";
                                echo "<td><b>Peers Performance Appraisal ".$i."<b></td>";
                                echo "<td>".$value['name']."</td>";
                                if(!$value['status']){
                                    echo "<td>".Html::a('Nilai', ['nilai', 'by'=>$value['by'],
                                                                            'id'=>$value['id'],
                                                                            'type'=>$value['type']                        
                                                                            ])."</td>";
                                }else{
                                    echo "<td>".Html::a('Ubah', ['ubahnilai', 'by'=>$value['by'],
                                                                                'id'=>$value['id'],
                                                                                'type'=>$value['type']                        
                                    ])."</td>";
                                }
                                echo "</tr>";
                                $i++;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class='row'>
        <div class ='col-md-6'>
            <table class='table table-bordered table-striped'>
                <tbody>
                    <?php
                        if($superior!=null){
                            $i=1;
                            foreach ($superior as $key => $value) {
                                echo "<tr>";
                                echo "<td><b>Superior to Subordinate ".$i."<b></td>";
                                echo "<td>".$value['name']."</td>";
                                if(!$value['status']){
                                    echo "<td>".Html::a('Nilai', ['nilai', 'by'=>$value['by'],
                                                                            'id'=>$value['id'],
                                                                            'type'=>$value['type']                        
                                                                            ])."</td>";
                                }else{
                                    echo "<td>".Html::a('Ubah', ['ubahnilai', 'by'=>$value['by'],
                                                                                'id'=>$value['id'],
                                                                                'type'=>$value['type']                        
                                    ])."</td>";
                                }
                                echo "</tr>";
                                $i++;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class='row'>
        <div class ='col-md-6'>
            <table class='table table-bordered table-striped'>
                <tbody>
                    <?php
                        if($subordinate!=null){
                            $i=1;
                            foreach ($subordinate as $key => $value) {
                                echo "<tr>";
                                echo "<td><b>Subordinate to Superior".$i."<b></td>";
                                echo "<td>".$value['name']."</td>";
                                if(!$value['status']){
                                    echo "<td>".Html::a('Nilai', ['nilai', 'by'=>$value['by'],
                                                                            'id'=>$value['id'],
                                                                            'type'=>$value['type']                        
                                                                            ])."</td>";
                                }else{
                                    echo "<td>".Html::a('Ubah', ['ubahnilai', 'by'=>$value['by'],
                                                                                'id'=>$value['id'],
                                                                                'type'=>$value['type']                        
                                    ])."</td>";
                                }
                                echo "</tr>";
                                $i++;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php
    }else{
?>
    <div class='row'>
        <div class='col-md-12'>
            <div class="alert alert-warning alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                Anda belum di-assign untuk melakukan penilaian!
            </div>
        </div>
    </div>
<?php
    }   
?>
</div>