<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonalinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Karyawan Penilai';
$this->params['breadcrumbs'][] = ['label' => 'Periode', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$urlindex = Url::to(['index']);
?>
<div class="view">
    <div class='row'>
        <div class='col-md-2'>
            <p><h4>Periode Penilaian</h4></p>
        </div>
        <div class='col-md-3'>
            <p>
                <h4><?php echo Yii::$app->formatter->format($periode->Start, 'date')." - ".Yii::$app->formatter->format($periode->End, 'date' )?></h4>
            </p>
        </div>
        <div class='col-md-6'>
            <p>
                <?= Html::a('Export ToExcel', ['index'], ['class' => 'btn btn-success']) ?>
                <?= Html::a('Ubah Karyawan Penilai', ['index'], ['class' => 'btn btn-primary']) ?>
            </p>
        </div>
    </div>

    <div class='row'>
            <table class='table table-bordered table-striped'>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Karyawan</th>
                        <th>Squad</th>
                        <th>Job Position</th>
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
                        $i=1;
                        foreach ($model as $key => $value) {
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<td>".$value->employee->personal->FullName."</td>";
                            echo $value->employee->squad==null?"<td>-</td>":"<td>".$value->employee->squad->SquadName."</td>";
                            echo $value->employee->AKA_JobPosition==null?"<td>".$value->employee->jobPosition->JobPositionName."</td>":"<td>".$value->employee->AKA_JobPosition."</td>";
                            echo $value->PeersID1==null?"<td>-</td>":"<td>".$value->peersID1->personal->FullName."</td>";
                            echo $value->PeersID2==null?"<td>-</td>":"<td>".$value->peersID2->personal->FullName."</td>";
                            echo $value->SuperiorID1==null?"<td>-</td>":"<td>".$value->superiorID1->personal->FullName."</td>";
                            echo "<td>-</td>"; //superiorname2
                            echo $value->SubordinateID1==null?"<td>-</td>":"<td>".$value->subordinateID1->personal->FullName."</td>";
                            echo $value->SubordinateID2==null?"<td>-</td>":"<td>".$value->subordinateID2->personal->FullName."</td>";
                            echo "</tr>";
                            $i++;
                        }
                    ?>
                </tbody>
            </table>
            <div class="form-group">
                <div class="col-md-11"></div>
                <div class="col-md-1">
                    <p>
                        <button type ="button" class="btn btn-primary" id='kirim'>Kirim</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$script = <<< JS
document.getElementById("kirim").onclick = function(){
    alert('kirim');
    var url = "$urlindex";
    window.location.href=url;
};
JS;
$this->registerJs($script);
?>