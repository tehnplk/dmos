<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PatientDc $model */
$this->title = 'Update Patient Dc: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Patient Dcs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="patient-dc-update">



    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
