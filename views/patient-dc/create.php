<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PatientDc $model */

$this->title = 'Create Patient Dc';
$this->params['breadcrumbs'][] = ['label' => 'Patient Dcs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-dc-create">

    <h4>รายละเอียดการสอบสวนควบคุมโรค</h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
