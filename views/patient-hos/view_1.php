<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\MyDate;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PatientHos $model */
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'รายชื่อผู้ป่วย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<style>
    .info{
        text-decoration: underline
    }
    .pt {
        color: blue;
    }
    strong{
        color: gray
    }
</style>


<div class="container" style="margin-top: 1px;border: solid 1px #ccc;border-radius: 8px;padding: 15px">
    <div style="display: flex;justify-content: space-between;">
        <div>
            <?php if (\Yii::$app->user->identity->hoscode == $model->hoscode): ?>
                <?= Html::a('แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('ลบ', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])
                ?>
            <?php endif; ?>
        </div>
        <div>
            <?php if (!$model->accepted_hos): ?>
                <?=
                Html::a('ยืนยันการรับเคส', ['accept', 'id' => $model->id], [
                    'class' => 'btn btn-success',
                    'data' => [
                        'confirm' => \Yii::$app->user->identity->hosname,
                    ],
                ])
                ?>
            <?php endif; ?>
            <?php if (\Yii::$app->user->identity->hoscode == substr($model->accepted_hos, 0, 5)): ?>
                <?php
                echo Html::a('ยกเลิกการรับ', '#', [
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#rejectModal',
                    'class' => 'btn btn-info',
                ]);
                ?>
                <?=
                Html::a('สอบสวน/ควบคุมโรค', ['', 'id' => $model->id], [
                    'class' => 'btn btn-secondary',
                    'data' => [
                        'confirm' => 'ยังไม่เปิดใช้งาน',
                    ],
                ])
                ?>
            <?php endif; ?>

        </div>

    </div>
    <hr>
    <!-- First Row -->
    <div class="row">
        <div class="col-md"><strong>รหัสหน่วยบริการ:</strong> <span class="pt"><?= $model->hoscode ?></span></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('hosname') ?>:</strong> <span class="pt"><?= $model->hosname ?></span></div>
    </div>
    <hr>
    <!-- Second Row -->
    <div class="row">

        <div class="col-md"><strong>HN:</strong> <?= $model->hn ?></div>
        <div class="col-md"><strong>เลขบัตรปชช:</strong> <?= $model->cid ?></div>
        <div class="col-md""><strong>ชื่อ-นามสกุล:</strong><?= $model->pname ?> <?= $model->fname ?> <?= $model->lname ?></div>
    </div>



    <!-- Fourth Row -->
    <div class="row">
        <div class="col-md"><strong><?= $model->getAttributeLabel('gender') ?>:</strong> <?= $model->gender ?></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('birth_date') ?>:</strong> <?= MyDate::toTh($model->birth_date) ?></div>
        <div class="col-md"><strong>อายุ:</strong> <?= $model->age_y ?>ปี <?= $model->age_m ?>เดือน</div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('occupat') ?>:</strong> <?= $model->coccupat->name ?></div>

    </div>
    <hr>
    <!-- Sixth Row -->
    <p class="info">ที่อยู่ขณะป่วย:</p>
    <div class="row">
        <div class="col-md"><strong><?= $model->getAttributeLabel('prov') ?>:</strong> <?= $model->prov ?></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('amp') ?>:</strong> <?= $model->camp->name ?></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('tmb') ?>:</strong> <?= $model->ctmb->name ?></div>
    </div>

    <!-- Seventh Row -->
    <div class="row">
        <div class="col-md"><strong><?= $model->getAttributeLabel('moo') ?>:</strong> <?= substr($model->moo, 6, 2) ?>-<?= $model->cmoo->name ?></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('street') ?>:</strong> <?= $model->street ?></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('place') ?>:</strong> <?= $model->place ?></div>
    </div>

    <!-- Eighth Row -->
    <div class="row">
        <div class="col-md"><strong><?= $model->getAttributeLabel('addr') ?>:</strong> <?= $model->addr ?></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('tel') ?>:</strong> <?= $model->tel ?></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('family') ?>:</strong> <?= $model->family ?></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('addr_note') ?>:</strong> <?= $model->addr_note ?></div>
    </div>
    <hr><!-- comment -->
    <p class="info">ข้อมูลการเจ็บป่วย:<p>
        <!-- Ninth Row -->
    <div class="row">

        <div class="col-md"><strong><?= $model->getAttributeLabel('date_sick') ?>:</strong> <?= MyDate::toTh($model->date_sick) ?></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('date_visit') ?>:</strong> <?= MyDate::toTh($model->date_visit) ?></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('date_dx') ?>:</strong> <?= MyDate::toTh($model->date_dx) ?></div>

    </div>

    <!-- Tenth Row -->
    <div class="row">
        <div class="col-md"><strong><?= $model->getAttributeLabel('symptom') ?>:</strong> <?= $model->symptom ?></div>
    </div>
    <div class="row">

        <div class="col-md"><strong><?= $model->getAttributeLabel('dx') ?>:</strong> <?= "{$model->dx}-{$model->cdx->name}" ?></div>
    </div>
    <div class="row">

        <div class="col-md"><strong><?= $model->getAttributeLabel('lab') ?>:</strong> <?= $model->lab ?></div>

    </div>
    <!-- Eleventh Row -->
    <div class="row">
        <div class="col-md"><strong><?= $model->getAttributeLabel('doctor') ?>:</strong> <?= $model->doctor ?></div>        

    </div>

    <!-- Twelfth Row -->
    <div class="row">

        <div class="col-md"><strong><?= $model->getAttributeLabel('note') ?>:</strong> <?= $model->note ?></div>

    </div>
    <hr>
    <p class="info">ผู้แจ้งเคส :</p>
    <!-- Thirteenth Row -->
    <div class="row">
        <div class="col-md"><strong>วันที่แจ้ง :</strong> <?= $model->created_at ?></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('reporter') ?>:</strong> <?= $model->reporter ?></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('reporter_position') ?>:</strong> <?= $model->reporter_position ?></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('reporter_tel') ?>:</strong> <?= $model->reporter_tel ?></div>

    </div>

    <!-- Fourteenth Row -->

    <hr><!-- comment -->
    <p class="info">ผู้รับเคส:</p>
    <!-- Fifteenth Row -->
    <div class="row">
        <div class="col-md"><strong><?= $model->accepted_hos ?></strong></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('accepted_at') ?>:</strong> <?= $model->accepted_at ?></div>
        <div class="col-md"><strong><?= $model->getAttributeLabel('accepted_note') ?>:</strong> <?= $model->accepted_note ?></div>
    </div>

    <!-- Sixteenth Row -->

</div>

<?php
Modal::begin([
    'id' => 'rejectModal',
    'title' => 'การยืนยัน',
    'size' => 'md',
        //'footer' => '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>',
]);
?>

<div class="modal-body">
    <?php
    $form = ActiveForm::begin([
                'id' => 'modal-reject-form',
                'action' => ['reject'],
                'method' => 'post',
    ]);
    ?>

    <?= Html::hiddenInput('id', $model->id) ?>
    <?= $form->field($model, 'accepted_reject_note') ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success', 'id' => 'submitModalForm']) ?>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php Modal::end(); ?>



