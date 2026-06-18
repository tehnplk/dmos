<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\PatientHos $model */
$this->title = 'แก้ไข: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'รายชื่อ', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="patient-hos-update">

    <div class="container d-flex justify-content-between mb-2">
        <h4><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg> แก้ไขข้อมูล</h4>
        <button class="btn btn-info" onclick="window.history.back();">ยกเลิก</button>
    </div>

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>

<?php
$js = <<<JS
      
        
JS;

$this->registerJs($js);
