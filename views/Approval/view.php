<meta name="csrf-token" content="{{ csrf_token() }}" />
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonalinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Approval: Daftar Karyawan Penilai';
$this->params['breadcrumbs'][] = ['label' => 'Periode', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
// $urlkirim = Url::to(['kirim','id'=>$_GET['id']]);
$urlindex = Url::to(['index']);
$urlredirect = Url::to(['view','id'=>$_GET['id']]);
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
                <?= Html::a('Export ToExcel', ['export-penilai','id'=>$periode->PeriodeID], ['class' => 'btn btn-success']) ?>
                <!-- <?= Html::a('Ubah Karyawan Penilai', ['update-existing', 'id'=>$_GET['id']], ['class' => 'btn btn-primary']) ?> -->
                <?php
                    if($status==false){
                        echo "<span class='badge'>Belum Aktif <i class='fa fa-times-circle'></i></span>";
                    }else{
                        echo "<span class='badge'>Aktif <i class='fa fa-check-circle'></i></span>";
                    }
                ?>
            </p>
        </div>
    </div>

    <div class='row'>
        <div id="loading" style="display: none;">
            <center>
                    <p><b>Loading...</b></p>
            </center>
        </div>
        <form action="<?php echo Url::to(['kirim', 'id'=>$_GET['id']])?>" id="approve" method='post'>
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
                        echo "<input type='hidden' name='mode' id='mode' value=1 />";
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
                            echo $value->SuperiorID2==null?"<td>-</td>":"<td>".$value->superiorID2->personal->FullName."</td>"; //superiorname2
                            echo $value->SubordinateID1==null?"<td>-</td>":"<td>".$value->subordinateID1->personal->FullName."</td>";
                            echo $value->SubordinateID2==null?"<td>-</td>":"<td>".$value->subordinateID2->personal->FullName."</td>";
                            echo "</tr>";
                            $i++;
                        }
                    ?>
                </tbody>
            </table>
    </div>
    <?php
        if($status==false){
    ?>
        <div class='row'>
            <div class="form-group">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <label for="alasan">Isi filed notes untuk menolak, kosongkan field notes untuk menerima daftar karyawan penilai</label>
                    <textarea class='form-control' id='alasan' rows='4' name='alasan'></textarea>
                </div>  
                <div class="col-md-1"></div>
            </div>
        </div>
    <?php
        }
    ?>

    <br><br>
    <div class='row'>
            <div class="form-group">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <?php
                        if($status==true){
                    ?>
                        <p>
                            <button type="button" class="btn btn-danger" id='batal' disabled>Batal</button>
                            <button type="button" class="btn btn-success" id='terima' disabled>Terima</button>
                            <button type ="button" class="btn btn-primary" id='tolak' disabled>Tolak</button>
                        </p>
                    <?php
                        }else{
                    ?>
                        <p>
                            <button type="button" class="btn btn-danger" id='batal'>Batal</button>
                            <button type="button" class="btn btn-success" id='terima'>Terima</button>
                            <button type ="button" class="btn btn-primary" id='tolak' disabled>Tolak</button>
                        </p>
                    <?php
                        }
                    ?>

                </div>
            </div>
        </form>
    </div>
</div>

<?php
$script = <<< JS
function execute(method, url,datas){
    console.log(datas);
    $('#loading').show();
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: method,
        url: url,
        data: datas, // serializes the form's elements.
        success: function(response)
        {
            var response = JSON.parse(response);
            alert(response.message);
            window.location.href = response.url;
            $('#loading').hide();
        },
        error : function(xhr, ajaxOptions, thrownError){
            console.log(xhr.status);
            console.log(xhr.responseText);
            console.log(thrownError);
            alert('All data have been approved and activated successfully.');
            window.location.href = "$urlredirect";
            $('#loading').hide();
        },
    });
}
document.getElementById('alasan').onfocus=function(e){
    document.getElementById("tolak").disabled = false;
    document.getElementById("terima").disabled = true;
};
document.getElementById('alasan').onfocusout=function(e){
    document.getElementById("tolak").disabled = false;
    document.getElementById("terima").disabled = false;
};
document.getElementById('terima').onclick = function(e){
    e.preventDefault();
    var form = $("#approve");
    var url = form.attr('action');
    var method = form.attr('method');
    execute(method, url,form.serialize());
};
document.getElementById("batal").onclick = function(){
    var url = "$urlindex";
    window.location.href=url;
};
document.getElementById('tolak').onclick = function(e){
    e.preventDefault();
    var textarea = $('#alasan');
    if (textarea.val()=='') {
        alert('Field must be filled!');
    }else{
        var form = $("#approve");
        var url = form.attr('action');
        var method = form.attr('method');
        document.getElementById("mode").value = 0;
        execute(method, url,form.serialize());
        // console.log(form.serializeArray());
        // console.log(url);
    }
};
JS;
$this->registerJs($script);
?>