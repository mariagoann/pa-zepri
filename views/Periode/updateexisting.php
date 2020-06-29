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
$urlindex = Url::to(['view','id'=>$_GET['id']]);
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
        <!-- <div class='col-md-6'>
            <p>
                <?= Html::a('Export ToExcel', ['index'], ['class' => 'btn btn-success']) ?>
            </p>
        </div> -->
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
                            echo "<input type='hidden' name='paid[]' value='".$value['paid']."' />";
                            echo "<input type='hidden' name='employeeid[]' value='".$value['employeeid']."' />";
                            echo "<td>".$value['name']."</td>";
                            echo "<td>".$value['squad']."</td>";
                            echo $value['aliasJob']==null?"<td>".$value['jobposition']."</td>":"<td>".$value['aliasJob']."</td>";
                            if($value['peers']!=null){
                                echo "<td>";
                                echo "<select class='form-control' name='peersid1id[]'>";
                                foreach ($value['peers'] as $key => $_value) {
                                   if($value['vpeersid1']!=null && $value['vpeersid1'] == $_value['id']){
                                     echo "<option value='".$_value['id']."' selected>".$_value['name']."</option>";
                                   }else{
                                        echo "<option value='".$_value['id']."'>".$_value['name']."</option>";
                                   }
                                }
                                echo "</select>";
                                echo "</td>";
                                if(count($value['peers'])>1){
                                    echo "<td>";
                                    echo "<select class='form-control' name='peersid2id[]'>";
                                    foreach ($value['peers'] as $key => $_value) {
                                        if($value['vpeersid2']!=null && $value['vpeersid2'] == $_value['id']){
                                            echo "<option value='".$_value['id']."' selected>".$_value['name']."</option>";
                                        }else{
                                            echo "<option value='".$_value['id']."'>".$_value['name']."</option>";
                                        }
                                    }
                                    echo "</select>";
                                    echo "</td>";
                                }else{
                                    echo "<td><input type='hidden' class='form-control' name='peersid2id[]' value=0 />-</td>";
                                }
                            }else{
                                echo "<td><input type='hidden' class='form-control' name='peersid1id[]' value=0 />-</td>";
                                echo "<td><input type='hidden' class='form-control' name='peersid2id[]' value=0 />-</td>";
                            }

                            if($superiors!=null){
                                echo "<td>";
                                echo "<select class='form-control' name='superiorid1[]'>";
                                foreach ($superiors as $key => $_value) {
                                    if($_value['id']==$value['vsuperiorid1']){
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
                                    if($_value['id']==$value['vsuperiorid2']){
                                        echo "<option value='".$_value['id']."' selected>".$_value['name']."</option>";
                                    }else{
                                        echo "<option value='".$_value['id']."'>".$_value['name']."</option>";
                                    }
                                }
                                echo "</select>";
                                echo "</td>";
                            }else{
                                echo "<td><input type='hidden' class='form-control' name='superiorid1[]' value=0 />-</td>";
                                echo "<td><input type='hidden' class='form-control' name='superiorid2[]' value=0 />-</td>";
                            }
                        
                            if($value['subordinate']!=null){
                                echo "<td>";
                                echo "<select class='form-control' name='subordinate1id[]'>";
                                foreach ($value['subordinate'] as $key => $_value) {
                                    if($value['vsubordinateid1']!=null && $value['vsubordinateid1'] == $_value['id']){
                                        echo "<option value='".$_value['id']."' selected>".$_value['name']."</option>";
                                      }else{
                                           echo "<option value='".$_value['id']."'>".$_value['name']."</option>";
                                      }
                                }
                                echo "</select>";
                                echo "</td>";

                                if(count($value['subordinate'])>1){
                                    echo "<td>";
                                    echo "<select class='form-control' name='subordinate2id[]'>";
                                    $i=0;
                                    foreach ($value['subordinate'] as $key => $_value) {
                                        if($value['vsubordinateid2']!=null && $value['vsubordinateid2'] == $_value['id']){
                                            echo "<option value='".$_value['id']."' selected>".$_value['name']."</option>";
                                          }else{
                                               echo "<option value='".$_value['id']."'>".$_value['name']."</option>";
                                          }
                                       $i++;
                                    }
                                    echo "</select>";
                                    echo "</td>";
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