<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\widgets\MyDatePicker;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;
use app\components\MyLookUp;
?>

<style>
    .info{
        font-size: 22px;
        text-decoration: underline;
    }
    .help-block{
        font-size: 12px!important;
        color: red
    }
    .form-control{
        color: blue;
        font-weight: bold;
    }
    .select2-selection__rendered{
        color: blue !important;
        font-weight: bold;
    }
    input::placeholder {
        color: gray; /* Change to your desired color */
        opacity: 0.5; /* Optional: set opacity, 1 is fully opaque */
    }

</style>
<div class="patient-hos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container" style="padding: 15px;border: solid 1px #0062cc;border-radius: 8px">
        <p class='info'>ข้อมูลหน่วยงาน</p>
        <div class="row">
            <div class="col-md">
                <?= $form->field($model, 'hoscode')->textInput(['maxlength' => true, 'disabled' => true]) ?>
            </div>
            <div class="col-md">
                <?= $form->field($model, 'hosname')->textInput(['maxlength' => true, 'disabled' => true]) ?>
            </div>
        </div>

        <p class="info">ข้อมูลผู้ป่วย</p>
        <div class="row">
            <div class="col-md">
                <?= $form->field($model, 'hn')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md">
                <?= $form->field($model, 'cid')->textInput(['maxlength' => true]) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md">
                <?= $form->field($model, 'pname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md">
                <?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md">
                <?= $form->field($model, 'lname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md">
                <?= $form->field($model, 'gender')->dropDownList(['ชาย' => 'ชาย', 'หญิง' => 'หญิง'], ['prompt' => '-']) ?>
            </div>
        </div>

        <div class="row">
            
            <div class="col-md">
                <?= $form->field($model, 'age_y')->textInput() ?>
            </div>
            <div class="col-md">
                <?= $form->field($model, 'age_m')->textInput() ?>
            </div>
            <div class="col-md">
                <?php
                echo $form->field($model, 'occupat')->dropDownList(
                        \yii\helpers\ArrayHelper::map(app\models\Coccupat::find()->all(), 'code', 'name'),
                        ['prompt' => '-']
                );
                ?>
            </div>
        </div>
        <p class="info">ที่อยู่ขณะป่วย</p>
        <div class="row">

            <div class="col-md">
                <?= $form->field($model, 'prov')->textInput(['maxlength' => true, 'disabled' => true]) ?>
            </div>
            <div class="col-md">
                <?php
                echo $form->field($model, 'amp')->dropDownList(
                        \yii\helpers\ArrayHelper::map(app\models\Camp::find()->all(), 'code', 'name'),
                        ['id' => 'amp-id', 'prompt' => '-']
                );
                ?>
            </div>

            <div class="col-md">
                <?php
                echo $form->field($model, 'tmb')->widget(DepDrop::class, [
                    'options' => ['id' => 'tmb-id'],
                    'data' => MyLookUp::list_tmb($model->amp),
                    'pluginOptions' => [
                        'depends' => ['amp-id'],
                        'placeholder' => '-',
                        //'initialize' => true,
                        'url' => Url::to(['lookup/tmb-list']), // URL to the action created above
                    ]
                ]);
                ?>
            </div>
            <div class="col-md">
                <?php
                echo $form->field($model, 'moo')->widget(DepDrop::class, [
                    'options' => ['id' => 'moo-id'],
                    'data' => MyLookUp::list_moo($model->tmb),
                    'pluginOptions' => [
                        'depends' => ['tmb-id'],
                        'placeholder' => '-',
                        //'initialize' => true,
                        'url' => Url::to(['lookup/moo-list']), // URL to the action created above
                    ]
                ]);
                ?>
            </div>
        </div>

        <div class="row">

            <div class="col-md">
                <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md">
                <?= $form->field($model, 'addr')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-md">
                <?= $form->field($model, 'place')->textInput(['maxlength' => true]) ?>
            </div>
        </div>


        <div class="row">
            <div class="col-md">
                <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md">
                <?= $form->field($model, 'family')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md">
                <?= $form->field($model, 'addr_note')->textInput(['maxlength' => true]) ?>
            </div>

        </div>
        <p class="info">ข้อมูลการเจ็บป่วย</p>
        <div class="row">
            <div class="col-md">
                <?php
                echo MyDatePicker::widget([
                    'model' => $model,
                    'attribute' => 'date_sick',
                ]);
                ?>
                <?= $form->field($model, 'date_sick')->textInput(['maxlength' => true, 'style' => 'display:none'])->label(false) ?>
            </div>
            <div class="col-md">

                <?php
                echo MyDatePicker::widget([
                    'model' => $model,
                    'attribute' => 'date_visit'
                ]);
                ?>
                <?= $form->field($model, 'date_visit')->textInput(['maxlength' => true, 'style' => 'display:none'])->label(false) ?>
            </div>
            <div class="col-md">
                <?= $form->field($model, 'symptom')->textInput(['maxlength' => true]) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md">
                <?php
                echo $form->field($model, 'dx')->dropDownList(
                        \yii\helpers\ArrayHelper::map(app\models\CDx::find()->select(['code', "concat(code,'-',name) as name"])->all(), 'code', 'name'),
                        ['prompt' => '-']
                );
                ?>
            </div>
            <div class="col-md">
                <?php
                echo MyDatePicker::widget([
                    'model' => $model,
                    'attribute' => 'date_dx',
                ]);
                ?>
            </div>
            <div class="col-md">
                <?= $form->field($model, 'doctor')->textInput(['maxlength' => true]) ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md">
                <?= $form->field($model, 'lab')->textarea(['rows' => 6]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md">
                <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <p class="info">ผู้รายงาน</p>
        <div class="row">
            <div class="col-md">
                <?= $form->field($model, 'reporter')->textInput(['maxlength' => true, 'placeholder' => 'นายสมชาย สบายดี']) ?>
            </div>
            <div class="col-md">
                <?= $form->field($model, 'reporter_position')->textInput(['maxlength' => true, 'placeholder' => 'นักวิชาการสาธารณสุขชำนาญการ']) ?>
            </div>
            <div class="col-md">
                <?= $form->field($model, 'reporter_tel')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="form-group" style="text-align: center">
            <?= Html::submitButton('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>  บันทึก ', ['class' => 'btn btn-success']) ?>
        </div>
    </div>





    <?php ActiveForm::end(); ?>

</div>
