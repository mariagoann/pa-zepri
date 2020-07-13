<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
// use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Paparameter */
/* @var $form yii\widgets\ActiveForm */
$periodePenilaian = Yii::$app->formatter->format($model->periode->Start, 'date')." - ".
Yii::$app->formatter->format($model->periode->End, 'date' );
//role 
$role = Yii::$app->session->has('role')?Yii::$app->session->get('role'):null;
$isSuperior = Yii::$app->session->has('isSuperior')?Yii::$app->session->get('isSuperior'):null;
if($isSuperior || $role=='admin'){
    $this->params['breadcrumbs'][] = ['label' => 'Hasil Penilaian', 'url' => ['view-nilai','id'=>$model->PeriodeID]];
}else{
    $this->params['breadcrumbs'][] = ['label' => 'Hasil Penilaian', 'url' => ['hasil-penilaian']];
}

$urlsave = $role=='admin'?Url::to(['savetrack','id'=>$_GET['id']]):null;
$this->title = 'Detail Hasil Penilaian Kinerja Karyawan';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
   th{
       text-align:center
   }
   table {
        border: 2px solid black;
    }
</style>
<div class="detailnilai">
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
            <table class='table table-bordered' style="background-color: white">
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
                        if(($role=='admin'||$isSuperior) && !$flag){
                            echo "<tr>";
                            echo $self!=null?"<td>".Html::a(
                                $self['by'],
                                ['/paparameter/detail','id'=>$self['id'],'idc'=>$self['idc']])."</td>":"<td>-</td>";
                            echo $superior1!=null?"<td>".Html::a(
                                $superior1['by'],
                                ['/paparameter/detail','id'=>$superior1['id'],'idc'=>$superior1['idc']])."</td>":"<td>-</td>";
                            echo $superior2!=null?"<td>".Html::a(
                                $superior2['by'],
                                ['/paparameter/detail','id'=>$superior2['id'],'idc'=>$superior2['idc']])."</td>":"<td>-</td>";
                            echo $self!=null?"<td>".Html::a(
                                $self['by'],
                                ['/paparameter/detail','id'=>$self['id'],'idc'=>$self['idc']])."</td>":"<td>-</td>";
                            echo $peers1!=null?"<td>".Html::a(
                                $peers1['by'],
                                ['/paparameter/detail','id'=>$peers1['id'],'idc'=>$peers1['idc']])."</td>":"<td>-</td>";
                            echo $peers2!=null?"<td>".Html::a(
                                $peers2['by'],
                                ['/paparameter/detail','id'=>$peers2['id'],'idc'=>$peers2['idc']])."</td>":"<td>-</td>";
                            echo $superior1!=null?"<td>".Html::a(
                                $superior1['by'],
                                ['/paparameter/detail','id'=>$superior1['id'],'idc'=>$superior1['idc']])."</td>":"<td>-</td>";
                            echo $superior2!=null?"<td>".Html::a(
                                $superior2['by'],
                                ['/paparameter/detail','id'=>$superior2['id'],'idc'=>$superior2['idc']])."</td>":"<td>-</td>";
                            echo $subordinate1!=null?"<td>".Html::a(
                                $subordinate1['by'],
                                ['/paparameter/detail','id'=>$subordinate1['id'],'idc'=>$subordinate1['idc']])."</td>":"<td>-</td>";
                            echo $subordinate2!=null?"<td>".Html::a(
                                $subordinate2['by'],
                                ['/paparameter/detail','id'=>$subordinate2['id'],'idc'=>$subordinate2['idc']])."</td>":"<td>-</td>";
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
                        if($role=='admin'){
                            echo "<td colspan=7> 
                                    <textarea class='form-control' id='track' rows='4' name='track'>".$model->TrackRecord."</textarea>
                                </td>
                                <td> <button type='button' class='btn btn-success' id='simpan'><span class='fa fa-check'></span></button>
                                </td>";
                        }else{
                            echo "<td colspan=8>".$model->TrackRecord."</td>";
                        }
                        echo "<td colspan=2><b><p style='font-size:35px'>".number_format($model->TotalScore,4)."</p></b></td>";
                        echo "</tr>";
                    ?>
                </tbody>
            </table>
            <p>
                <?php
                    $button = Html::a('Generate To PDF', ['genpdf','id'=>$model->PAComponentID], ['class' => 'btn btn-primary']);
                    $eid = $model->EmployeeID;
                    if(!$isSuperior && $role!='admin' ){
                        $button = Html::a('Generate To PDF', ['genpdf','id'=>null,'eid'=>$eid,'pid'=>$model->PeriodeID], ['class' => 'btn btn-primary']);
                    }
                    echo $button;
                ?>
            </p>
        </div>
    </div>
</div>

<?php
$script = <<< JS
$("#simpan").click(function(event) {
    var url = '$urlsave';
    var _data = document.getElementById("track").value;
    var data = {track:_data};
    $.ajax({
        type: 'post',
        url: url,
        data: data, 
        success: function(response)
        {
            var response = JSON.parse(response);
            alert(response.message);
            window.location.href = response.url;
        },
        error: function(){
            alert('Something went wrong');
        }
    });
});
JS;
$this->registerJs($script);
?>
