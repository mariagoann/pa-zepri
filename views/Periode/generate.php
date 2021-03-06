<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonalinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Generate Karyawan Penilai';
$this->params['breadcrumbs'][] = ['label' => 'Periode', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$urlindex = Url::to(['index']);
?>
<div class="generate-index">
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
                <?= Html::a('Ubah Karyawan Penilai', ['update-generate','id'=>$_GET['id']], ['class' => 'btn btn-primary']) ?>
            </p>
        </div>
    </div>

    <div class='row'>
        <form action="<?php echo Url::to(['save', 'id'=>$_GET['id']])?>" id="generate" method='post'>
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
                        echo "<input type='hidden' name='mode' id='mode' value=0 />";
                        $i=1;
                        foreach ($arr as $key => $value) {
                            echo "<tr>";
                            echo "<td>$i</td>";
                            echo "<input type='hidden' name='employeeid[]' value='".$value['employeeid']."' />";
                            echo "<td>".$value['name']."</td>";
                            echo "<td>".$value['squad']."</td>";
                            echo $value['aliasJob']==null?"<td>".$value['jobposition']."</td>":"<td>".$value['aliasJob']."</td>";
                            if($value['peers']!=null){
                                echo "<input type='hidden' name='peersid1id[]' value='".$value['peers'][0]['id']."' />";
                                echo "<td>".$value['peers'][0]['name']."</td>";
                                if(count($value['peers'])>1){
                                    echo "<input type='hidden' name='peersid2id[]' value='".$value['peers'][1]['id']."' />";
                                    echo "<td>".$value['peers'][1]['name']."</td>";
                                }else{
                                    echo "<td><input type='hidden' class='form-control' name='peersid2id[]' value=0 />-</td>";
                                }
                            }else{
                                echo "<td><input type='hidden' class='form-control' name='peersid1id[]' value=0 />-</td>";
                                echo "<td><input type='hidden' class='form-control' name='peersid2id[]' value=0 />-</td>";
                            }
                            echo "<input type='hidden' name='superiorid1[]' value='".$value['superior1id']."' />";
                            echo "<td>".$value['superior1name']."</td>";
                            echo "<td>-</td>"; //superiorname2
                            if($value['subordinate']!=null){
                                echo "<input type='hidden' name='subordinate1id[]' value='".$value['subordinate'][0]['id']."' />";
                                echo "<td>".$value['subordinate'][0]['name']."</td>";
                                if(count($value['subordinate'])>1){
                                    echo "<input type='hidden' name='subordinate2id[]' value='".$value['subordinate'][1]['id']."' />";
                                    echo "<td>".$value['subordinate'][1]['name']."</td>";
                                }else{
                                    echo "<td><input type='hidden' class='form-control' name='subordinate2id[]' value=0 />-</td>";
                                }
                            }else{
                                echo "<td><input type='hidden' class='form-control' name='subordinate1id[]' value=0 />-</td>";
                                echo "<td><input type='hidden' class='form-control' name='subordinate2id[]' value=0 />-</td>";
                            }
                            echo "</tr>";
                            $i++;
                        }
                    ?>
                </tbody>
            </table>
            <div class="form-group">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <p>
                        <button type="button" class="btn btn-danger" id='batal'>Batal</button>
                        <button type="button" class="btn btn-success" id='simpan'>Simpan</button>
                        <button type ="button" class="btn btn-primary" id='kirim'>Kirim</button>
                    </p>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>

<?php
$script = <<< JS
// $("#generate").submit(function(e) {
//     e.preventDefault(); // avoid to execute the actual submit of the form.
//     var form = $(this);
//     var url = form.attr('action');
//     var _data = form.serialize();
//     $.ajax({
//         type: form.attr('method'),
//         url: url,
//         data: _data, // serializes the form's elements.
//         success: function(response)
//         {
//             var response = JSON.parse(response);
//             alert(response.message);
//             window.location.href = response.url;
//         },
//         error: function(){
//             alert('Something went wrong');
//         }
//     });
// });
function execute(method, url,datas){
    $.ajax({
        type: method,
        url: url,
        data: datas, // serializes the form's elements.
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
document.getElementById('simpan').onclick = function(e){
    e.preventDefault();
    var form = $("#generate");
    var url = form.attr('action');
    var method = form.attr('method');
    execute(method, url,form.serialize());
};
document.getElementById("batal").onclick = function(){
    var url = "$urlindex";
    window.location.href=url;
};
document.getElementById('kirim').onclick = function(e){
    e.preventDefault();
    var form = $("#generate");
    var url = form.attr('action');
    var method = form.attr('method');
    document.getElementById("mode").value = 1;
    execute(method, url,form.serialize());
};
JS;
$this->registerJs($script);
?>