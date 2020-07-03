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
                        if($role=='admin' && $model->TrackRecord==null){
                            echo "<td colspan=8> 
                                    <input type='text' class='form-control' id='track' name='track'> 
                                </td>";
                        }else{
                            echo "<td colspan=8>".$model->TrackRecord."</td>";
                        }
                        echo "<td colspan=2><b>".number_format($model->TotalScore,2)."</b></td>";
                        echo "</tr>";
                    ?>
                </tbody>
            </table>
            <p>
                <?php
                    $button = Html::a('Generate To PDF', ['genpdf','id'=>$model->PAComponentID], ['class' => 'btn btn-primary']);
                    $eid = Yii::$app->session->get('employeeid');
                    if(!$isSuperior){
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
$("#track").keyup(function(event) {
    if (event.keyCode === 13) {
        var url = '$urlsave';
        var data = {track:this.value};
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
    }
});
JS;
$this->registerJs($script);
?>
