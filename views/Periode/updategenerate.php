<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PersonalinfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ubah Karyawan Penilai';
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
                        $a=1;
                        foreach ($arr as $key => $value) {
                            $peers = [
                                0=>[
                                    'id'=>0,
                                    'name'=>'Pilih Peers',
                                ]
                            ];
                            $subordinate = [
                                0=>[
                                    'id'=>0,
                                    'name'=>'Pilih Subordinate',
                                ]
                            ];
                            $peers = $value['peers']!=null? array_merge($peers,$value['peers']):null;
                            $subordinate = $value['subordinate']!=null?array_merge($subordinate,$value['subordinate']):null;
                            echo "<tr>";
                            echo "<td>$a</td>";
                            echo "<input type='hidden' name='employeeid[]' value='".$value['employeeid']."' />";
                            echo "<td>".$value['name']."</td>";
                            echo "<td>".$value['squad']."</td>";
                            echo $value['aliasJob']==null?"<td>".$value['jobposition']."</td>":"<td>".$value['aliasJob']."</td>";
                            if($peers!=null){
                                echo "<td>";
                                echo "<select class='form-control' name='peersid1id[]'>";
                                foreach ($peers as $key => $_value) {
                                    if($_value['id']==$value['vpeers1']){
                                        echo "<option value='".$_value['id']."' selected>".$_value['name']."</option>";
                                    }else{
                                        echo "<option value='".$_value['id']."'>".$_value['name']."</option>";
                                    }
                                }
                                echo "</select>";
                                echo "</td>";

                                echo "<td>";
                                echo "<select class='form-control' name='peersid2id[]'>";
                                foreach ($peers as $key => $_value) {
                                    if($_value['id']==$value['vpeers2']){
                                        echo "<option value='".$_value['id']."' selected>".$_value['name']."</option>";
                                    }else{
                                        echo "<option value='".$_value['id']."'>".$_value['name']."</option>";
                                    }
                                }
                                echo "</select>";
                                echo "</td>";
                            }else{
                                echo "<td><input type='hidden' class='form-control' name='peersid1id[]' value=0 />-</td>";
                                echo "<td><input type='hidden' class='form-control' name='peersid2id[]' value=0 />-</td>";
                            }

                            if($superiors!=null){
                                echo "<td>";
                                echo "<select class='form-control' name='superiorid1[]'>";
                                foreach ($superiors as $key => $_value) {
                                    if($_value['id']==$value['superior1id']){
                                        echo "<option value='".$_value['id']."' selected>".$_value['name']."</option>";
                                    }else{
                                        echo "<option value='".$_value['id']."'>".$_value['name']."</option>";
                                    }
                                }
                                echo "</select>";
                                echo "</td>";

                                echo "<td>";
                                echo "<select class='form-control' name='superiorid2[]'>";
                                foreach ($superiors as $key => $_value) {
                                   echo "<option value='".$_value['id']."'>".$_value['name']."</option>";
                                }
                                echo "</select>";
                                echo "</td>";
                            }else{
                                echo "<td><input type='hidden' class='form-control' name='superiorid1[]' value=0 />-</td>";
                                echo "<td><input type='hidden' class='form-control' name='superiorid2[]' value=0 />-</td>";
                            }
                        
                            if($subordinate!=null){
                                echo "<td>";
                                echo "<select class='form-control' name='subordinate1id[]'>";
                                foreach ($subordinate as $key => $_value) {
                                    if($_value['id']==$value['vsubordinate1']){
                                        echo "<option value='".$_value['id']."' selected>".$_value['name']."</option>";
                                    }else{
                                        echo "<option value='".$_value['id']."'>".$_value['name']."</option>";
                                    }
                                }
                                echo "</select>";
                                echo "</td>";

                                echo "<td>";
                                echo "<select class='form-control' name='subordinate2id[]'>";
                                foreach ($subordinate as $key => $_value) {
                                    if($_value['id']==$value['vsubordinate2']){
                                        echo "<option value='".$_value['id']."' selected>".$_value['name']."</option>";
                                    }else{
                                        echo "<option value='".$_value['id']."'>".$_value['name']."</option>";
                                    }
                                }
                                echo "</select>";
                                echo "</td>";

                            }else{
                                echo "<td><input type='hidden' class='form-control' name='subordinate1id[]' value=0 />-</td>";
                                echo "<td><input type='hidden' class='form-control' name='subordinate2id[]' value=0 />-</td>";
                            }
                            echo "</tr>";
                            $a++;
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
function execute(method, url,datas){
    console.log(datas);
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