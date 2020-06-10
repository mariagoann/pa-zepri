<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonalinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Karyawan yang Harus Anda Nilai';
$this->params['breadcrumbs'][] = ['label' => '?', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="generate-index">
    <div class='row'>
        <div class ='col-md-6'>
            <table class='table table-bordered table-striped'>
                <tbody>
                    <tr>
                        <td><b>Self Performance Appraisal</b></td>
                        <td><?php echo $employee->employee->personal->FullName;?></td>
                        <td><?= Html::a('Nilai', ['nilai', 'by'=>$employee->EmployeeID,
                                                'id'=>$employee->PerformanceAppraisalID,
                                                'type'=>'self'
                            ]) ?>
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
                                echo "<td>".$value->employee->personal->FullName."</td>";
                                echo "<td>".Html::a('Nilai', ['nilai', 'by'=>$employee->EmployeeID,
                                                            'id'=>$value->PerformanceAppraisalID,
                                                            'type'=>'peers-'.$i                        
                                ])."</td>";
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
                                echo "<td>".$value->employee->personal->FullName."</td>";
                                echo "<td>".Html::a('Nilai', ['nilai','by'=>$employee->EmployeeID,
                                                            'id'=>$value->PerformanceAppraisalID,
                                                            'type'=>'superior-'.$i
                                ])."</td>";
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
                                echo "<td>".$value->employee->personal->FullName."</td>";
                                echo "<td>".Html::a('Nilai', ['nilai', 'by'=>$employee->EmployeeID,
                                                        'id'=>$value->PerformanceAppraisalID,
                                                        'type'=>'subordinate-'.$i
                                ])."</td>";
                                echo "</tr>";
                                $i++;
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>