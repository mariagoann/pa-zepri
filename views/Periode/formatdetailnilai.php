<?php

use yii\helpers\Html;
use yii\helpers\Url;
$periodePenilaian = Yii::$app->formatter->format($model->periode->Start, 'date')." - ".
Yii::$app->formatter->format($model->periode->End, 'date' );
?>
<style>
   th{
       text-align:center;
       border: 1px solid black;
   }
   table {
        width : 800px;
    }
    td{
        width : 80px;
        border: 1px solid black;
    }
    #parent{
        padding: 0px, auto;
        width: 700px;
        height:100px;
        /* border:solid 1px #f00; */
    }
    #child-left{
        float: left;
        width: 170px;
        height:100px;
        /* border:solid 1px #0F0; */
    }
    #child-right{
        float: right;
        width: 500px;
        height:100px;
        /* border:solid 1px #00F; */
    }
</style>
<div class="container">
    <div class ='row'>
        <div class=col-md-1></div>
        <div class ='col-md-10'>
            <div id="parent">
                <div id="child-left">
                <img style='display:block;' src="<?=Url::to('@web/assets/dummy-logo2.jpg',true)?>" height='80' width='170'/>
                </div>
                <div id="child-right">
                    <h2 style="text-align:center;">Hasil Penilaian Kinerja Karyawan <br> PT.PROPERTY</h2>
                </div>
            </div>  
            <table class='table table-striped table-bordered '>
                <tbody>
                    <tr>
                        <td><b>Periode Penilaian</tb></td>
                        <td><?php echo $periodePenilaian?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Nomor Karyawan</tb></td>
                        <td><?php echo $model->employee->EmployeeNumber;?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Nama Karyawan</tb></td>
                        <td><?php echo $model->employee->personal->FullName;?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Join Date</tb></td>
                        <td><?php echo Yii::$app->formatter->format($model->employee->JoinDate, 'date');?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Job Position</tb></td>
                        <td><?php echo $model->employee->jobPosition->JobPositionName;?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Job Level</tb></td>
                        <td><?php echo $model->employee->level->LevelName;?>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Squad</tb></td>
                        <td><?php echo $model->employee->squad!=null?$model->employee->squad->SquadName:'-';?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class ='row'>
        <div class='col-md-1'></div>
        <div class ='col-md-10'>
            <table class='table table-bordered' style="background-color: white ">
                <thead>
                    <tr>
                        <th colspan="3" >Nilai Kinerja Karyawan</th>
                        <th colspan="7" >Core Values</th>
                    </tr>
                    <tr>
                        <th>Self</th>
                        <th>Superior 1</th>
                        <th>Superior 2</th>
                        <th>Self</th>
                        <th>Peers 1</th>
                        <th>Peers 2</th>
                        <th>Superior 1</th>
                        <th>Superior 2</th>
                        <th>Subordinate 1</th>
                        <th>Subordinate 2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $role = Yii::$app->session->has('role')?Yii::$app->session->get('role'):null;
                        $isSuperior = Yii::$app->session->has('isSuperior')?Yii::$app->session->get('isSuperior'):null;
                        if(($role=='admin'||$isSuperior) && !$flag){
                            echo "<tr>";
                            echo $self!=null?"<td>".$self['by']."</td>":"<td>-</td>";
                            echo $superior1!=null?"<td>".$superior1['by']."</td>":"<td>-</td>";
                            echo $superior2!=null?"<td>".$superior2['by']."</td>":"<td>-</td>";
                            echo $self!=null?"<td>".$self['by']."</td>":"<td>-</td>";
                            echo $peers1!=null?"<td>".$peers1['by']."</td>":"<td>-</td>";
                            echo $peers2!=null?"<td>".$peers2['by']."</td>":"<td>-</td>";
                            echo $superior1!=null?"<td>".$superior1['by']."</td>":"<td>-</td>";
                            echo $superior2!=null?"<td>".$superior2['by']."</td>":"<td>-</td>";
                            echo $subordinate1!=null?"<td>".$subordinate1['by']."</td>":"<td>-</td>";
                            echo $subordinate2!=null?"<td>".$subordinate2['by']."</td>":"<td>-</td>";
                            echo "<tr>";
                        }

                        echo "<tr>";
                        echo $self!=null?"<td>".$self['scoreEmployee']."</td>":"<td>-</td>";
                        echo $superior1!=null?"<td>".$superior1['scoreEmployee']."</td>":"<td>-</td>";
                        echo $superior2!=null?"<td>".$superior2['scoreEmployee']."</td>":"<td>-</td>";
                        echo $self!=null?"<td>".$self['avgValues']."</td>":"<td>-</td>";
                        echo $peers1!=null?"<td>".$peers1['avgValues']."</td>":"<td>-</td>";
                        echo $peers2!=null?"<td>".$peers2['avgValues']."</td>":"<td>-</td>";
                        echo $superior1!=null?"<td>".$superior1['avgValues']."</td>":"<td>-</td>";
                        echo $superior2!=null?"<td>".$superior2['avgValues']."</td>":"<td>-</td>";
                        echo $subordinate1!=null?"<td>".$subordinate1['avgValues']."</td>":"<td>-</td>";
                        echo $subordinate2!=null?"<td>".$subordinate2['avgValues']."</td>":"<td>-</td>";
                        echo "<tr>";

                        echo "<tr>";
                        echo "<td colspan=8><b>Notes:</b></td>";
                        echo "<td colspan=2><b>Nilai Akhir:</b></td>";
                        echo "</tr>";

                        echo "<tr rowspan=4>";
                        echo "<td colspan=8>".$model->TrackRecord."</td>";
                        echo "<td colspan=2><p style='font-size:35px'><b>".number_format($model->TotalScore,4)."</b></p></td>";
                        echo "</tr>";
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <br><br>
    <div style="display: block; width: 100%; min-width: 100px;">
        <div style="display: inline-block; text-align: right; width: 100%">
            <p>Jakarta, <?php echo date('d-m-Y');?></p>
            <BR><BR><BR><BR>
            <p>(<?=$sign;?>)</p>
        </div>
    </div>
</div>
