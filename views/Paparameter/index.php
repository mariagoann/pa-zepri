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

<?php if (Yii::$app->session->hasFlash('successedit')): ?>
    <div class="alert alert-success alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <?= Yii::$app->session->getFlash('successedit') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('successnilai')): ?>
    <div class="alert alert-success alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <?= Yii::$app->session->getFlash('successnilai') ?>
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
    if($all!=null && isset($all)){
?>

    <div class='row'>
        <div class ='col-md-6'>
            <table class='table table-bordered table-striped'>
                <tbody>
                    <?php
                        foreach ($all as $key => $value) {
                            echo "<tr>";
                            echo "<td><b>".$value['label']."</b></td>";
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
                Periode belum aktif atau Anda belum di-assign untuk melakukan penilaian!
            </div>
        </div>
    </div>
<?php
    }   
?>
</div>