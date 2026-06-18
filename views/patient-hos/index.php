<?php

use app\models\PatientHos;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\components\MyRole;
use yii\helpers\ArrayHelper;
use app\models\Cdx;
use app\models\Camp;

/** @var yii\web\View $this */
/** @var app\models\PatientHosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'รายชื่อผู้ป่วย';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .table td{
        font-size: 14px
    }
</style>

<div class="patient-hos-index">


    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'header' => '#',
                'value' => function ($model, $key, $index, $column) use ($dataProvider) {
                    // Calculate the reverse serial number
                    return $dataProvider->totalCount - $index;
                },
            ],
            //'id',
            //'pid',
            [
                'attribute' => 'hoscode',
                'label' => 'โรงพยาบาล',
                'value' => function ($model) {
                    return $model->hoscode . '-' . $model->hosname;
                }
            ],
            //'hosname',
            //'hn',
            //'cid',
            //'pname',
            [
                'attribute' => 'fname',
                'value' => function ($model) {
                    return "{$model->pname}{$model->fname} {$model->lname}";
                },
                'visible' => !\Yii::$app->user->isGuest
            ],
            //'lname',
            'gender',
            //'birth_date',
            'age_y',
            //'age_m',
            //'occupat',
            //'pic',
            //'prov',
            [
                'attribute' => 'amp',
                'filter' => ArrayHelper::map(Camp::find()->all(), 'code', 'name'),
                'value' => 'camp.name'
            ],
            [
                'attribute' => 'tmb',
                'value' => 'ctmb.name'
            ],
            [
                'attribute' => 'moo',
                'label' => 'หมู่',
                'value' => function ($model) {
                    return substr($model->moo, -2);
                }
            ],
            //'street',
            //'place',
            //'addr',
            //'tel',
            //'family',
            //'addr_note',
            //'date_sick',
			'date_dx:date',
            //'date_visit:date',
            //'symptom',
            [
                'attribute' => 'dx',
                'filter' => ArrayHelper::map(Cdx::find()->select(["code", "concat(code,'-',name) as name"])->all(), 'code', 'name'),
                'value' => 'cdx.name', // Access the related model's attribute
            ],
            //'date_dx',
            //'doctor',
            //'lab:ntext',
            //'dischage_type',
            //'date_dischage',
            //'note',
            //'reporter',
            //'reporter_position',
            //'reporter_tel',
            'created_at:date:วันที่รายงาน',
            //'created_by',
            //'updated_at',
            //'updated_by',
            [
                'attribute' => 'accepted_hoscode',
                'value' => function ($model) {
                    return $model->accepted_hoscode . '-' . $model->accepted_hosname;
                }
            ],
            'dc',
            //'accepted_at',
            //'accepted_note',
            //'accepted_reject_at',
            //'accepted_reject_note',
            [
                'class' => ActionColumn::className(),
                'template' => "{view}",
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a(
                               '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/><path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"/></svg>',
                                '#',
                                [
                                    'title' => Yii::t('app', 'View'),
                                    'onclick'=>"window.open('{$url}')",
                                    //'target' => '_blank',
                                    'data-pjax' => '0',
                                ]
                        );
                    },
                ],
            ],
        ],
    ]);
    ?>


</div>
