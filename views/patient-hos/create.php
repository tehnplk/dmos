<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PatientHos $model */
$this->title = 'เพิ่มรายงาน';
$this->params['breadcrumbs'][] = ['label' => 'รายชื่อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-hos-create">

    <div class="container"><h4><i class="fa fa-add"></i> แจ้งเคสผู้ป่วยรายใหม่</h4></div>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
