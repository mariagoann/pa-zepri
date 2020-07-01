<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\JobtitleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Title';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jobtitle-index">

    <p>
        <span>Daftar Job Title</span>
        <?= Html::a('Tambah Job Title', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Export To Excel', ['export'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'CodeJobTitle',
            [
                'attribute'=>'Job Title',
                'format'=>'raw',
                'value'=>'JobTitleName'
            ],

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{edit} {del}',
                'buttons'  => [
                    'edit' => function ($url, $model) {
                        $url = Url::to(['update', 'id' => $model->JobTitleID]);
                        return Html::a('<span class="fa fa-pencil"></span>', $url, ['title' => 'update']);
                    },
                    'del' => function ($url, $model) {
                        $url = Url::to(['delete', 'id' => $model->JobTitleID]);
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
