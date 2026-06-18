<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PatientHosSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="patient-hos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pid') ?>

    <?= $form->field($model, 'hoscode') ?>

    <?= $form->field($model, 'hosname') ?>

    <?= $form->field($model, 'hn') ?>

    <?php // echo $form->field($model, 'cid') ?>

    <?php // echo $form->field($model, 'pname') ?>

    <?php // echo $form->field($model, 'fname') ?>

    <?php // echo $form->field($model, 'lname') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'birth_date') ?>

    <?php // echo $form->field($model, 'age_y') ?>

    <?php // echo $form->field($model, 'age_m') ?>

    <?php // echo $form->field($model, 'occupat') ?>

    <?php // echo $form->field($model, 'pic') ?>

    <?php // echo $form->field($model, 'prov') ?>

    <?php // echo $form->field($model, 'amp') ?>

    <?php // echo $form->field($model, 'tmb') ?>

    <?php // echo $form->field($model, 'moo') ?>

    <?php // echo $form->field($model, 'street') ?>

    <?php // echo $form->field($model, 'place') ?>

    <?php // echo $form->field($model, 'addr') ?>

    <?php // echo $form->field($model, 'tel') ?>

    <?php // echo $form->field($model, 'family') ?>

    <?php // echo $form->field($model, 'addr_note') ?>

    <?php // echo $form->field($model, 'date_sick') ?>

    <?php // echo $form->field($model, 'date_visit') ?>

    <?php // echo $form->field($model, 'symptom') ?>

    <?php // echo $form->field($model, 'dx') ?>

    <?php // echo $form->field($model, 'date_dx') ?>

    <?php // echo $form->field($model, 'doctor') ?>

    <?php // echo $form->field($model, 'lab') ?>

    <?php // echo $form->field($model, 'discharge_type') ?>

    <?php // echo $form->field($model, 'date_discharge') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'reporter') ?>

    <?php // echo $form->field($model, 'reporter_position') ?>

    <?php // echo $form->field($model, 'reporter_tel') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'accepted_hos') ?>

    <?php // echo $form->field($model, 'accepted_at') ?>

    <?php // echo $form->field($model, 'accepted_note') ?>

    <?php // echo $form->field($model, 'accepted_reject_at') ?>

    <?php // echo $form->field($model, 'accepted_reject_note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
