<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OrganizationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Organization';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="organization-index">

    <p>
        <?= Html::a('Daftar Organization', ['index'], ['class' => 'btn btn-default']) ?>
        <?= Html::a('Tambah Organization', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'ID Organization',
                'format'=>'raw',
                'value'=>'CodeOrganization'
            ],
            [
                'attribute'=>'Nama Organization',
                'format'=>'raw',
                'value'=>'OrganizationName'
            ],

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{edit} {del}',
                'buttons'  => [
                    'edit' => function ($url, $model) {
                        $url = Url::to(['update', 'id' => $model->OrganizationID]);
                        return Html::a('<span class="fa fa-pencil"></span>', $url, ['title' => 'update']);
                    },
                    'del' => function ($url, $model) {
                        $url = Url::to(['delete', 'id' => $model->OrganizationID]);
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
