<?php

use app\models\PatientDc;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\components\MyDate;
use app\models\Cdx;

/** @var yii\web\View $this */
/** @var app\models\PatientDcSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
$this->title = 'การสอบสวนควบคุมโรค';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-dc-index">
    <div class="d-flex justify-content-between">
        <h4><?= $patient->pname ?><?= $patient->fname ?> <?= $patient->lname ?> อายุ <?= $patient->age_y ?>ปี </h4>
        <?php if ($patient->accepted_hoscode == \Yii::$app->user->identity->hoscode): ?>
            <?= Html::a('+สอบสวน/ควบคุมโรค', ['create', 'patient_id' => $patient->id], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>
    <div>รักษาที่ : <?= $patient->hosname ?></div>
    <div>วันรับรักษา :<?= MyDate::toTh($patient->date_visit) ?> </div>
    <?php
    $dx = Cdx::find()->where(['code' => "{$patient->dx}"])->one();
    ?>
    <div>วินิจฉัย : <?= $dx->name ?> </div>

    <p></p>


    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            //'patient_id',
            'dc_date:date',
            'dc_note:ntext',
            //'pic',
            //'hoscode',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            [
                'class' => ActionColumn::className(),
                'template' => "{update} {delete}",
                'visible'=> in_array(\Yii::$app->user->identity->hoscode , [$patient->accepted_hoscode])
            ],
        ],
    ]);
    ?>


</div>
