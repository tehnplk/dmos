<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'การส่งออกข้อมูล';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="export-form">
    <?php
    $form = ActiveForm::begin([
                'method' => 'post',
                    //'action' => ['export/export-csv-between-dates'], // Specify the action
    ]);
    ?>

    <?= $form->field($model, 'startDate')->input('date', ['required' => true]) ?>
    <?= $form->field($model, 'endDate')->input('date', ['required' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('ส่งออกข้อมูล', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
