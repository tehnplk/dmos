<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\widgets\MyDatePicker;

/** @var yii\web\View $this */
/** @var app\models\PatientDc $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="patient-dc-form">

    <?php $form = ActiveForm::begin(); ?>



    <?php
    echo MyDatePicker::widget([
        'model' => $model,
        'attribute' => 'dc_date'
    ]);
    ?>

    <?= $form->field($model, 'dc_note')->textarea(['rows' => 6]) ?>

   



    <div class="form-group">
        <?= Html::submitButton('บันทึก', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
