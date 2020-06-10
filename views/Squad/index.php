<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SquadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Squad';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="squad-index">
    <p>
        <?= Html::a('Daftar Squad', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Tambah Squad', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'ID Squad',
                'format'=>'raw',
                'value'=>'CodeSquad'
            ],
            [
                'attribute'=>'Squad',
                'format'=>'raw',
                'value'=>'SquadName'
            ],

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{edit} &nbsp; {del}',
                'buttons'  => [
                    'edit' => function ($url, $model) {
                        $url = Url::to(['update', 'id' => $model->SquadID]);
                        return Html::a('<span class="fa fa-pencil"></span>', $url, ['title' => 'update']);
                    },
                    'del' => function ($url, $model) {
                        $url = Url::to(['delete', 'id' => $model->SquadID]);
                        return Html::a('<span class="fa fa-trash"></span>', $url, [
                            'title'        => 'delete',
                            'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'data-method'  => 'post',
                        ]);
                    },
                ]],
        ],
    ]); ?>


</div>
