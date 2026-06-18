<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\MyDate;
use yii\bootstrap5\Modal;
use yii\bootstrap5\ActiveForm;
use app\components\MyRole;

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

    @media print {
        div {
            font-size: 11px; /* Adjust size for print */
        }
       
        .no-print {
            display: none!important
        }
    }

</style>


<div class="container" style="margin-top: 1px;border: solid 1px #ccc;border-radius: 8px;padding: 15px">
    <div style="display: flex;justify-content: space-between;" class='no-print'>
        <div class="d-flex flex-row gap-1">
            <div>
                <?php if (\Yii::$app->user->identity->hoscode == $model->hoscode || MyRole::can_all_update()): ?>
                    <?php
                    echo Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> ลบเคส', '#', [
                        'data-bs-toggle' => 'modal',
                        'data-bs-target' => '#deleteModal',
                        'class' => 'btn btn-danger',
                    ]);
                    ?>
                    <?= Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 14.66V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h5.34"></path><polygon points="18 2 22 6 12 16 8 16 8 12 18 2"></polygon></svg> แก้ไข', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

                <?php endif; ?>
            </div>
            <div>
                <?php if ($model->accepted_hoscode == 'ยังไม่รับ'): ?>
                    <?=
                    Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg> ทำการรับเคส', ['accept', 'id' => $model->id], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => \Yii::$app->user->identity->hosname,
                        ],
                    ])
                    ?>
                <?php endif; ?>

                <?php if ($model->accepted_hoscode != 'ยังไม่รับ'): ?>
                    <?=
                    Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/><path d="M14 3v5h5M12 18v-6M9 15h6"/></svg> สอบสวน/ควบคุมโรค', ['patient-dc/index', 'patient_id' => $model->id], [
                        'class' => 'btn btn-warning',
                        'target' => '_blank'
                    ])
                    ?>

                <?php endif; ?>
            </div>
        </div>
        <div class="d-flex flex-row gap-1">
            <?php if (\Yii::$app->user->identity->hoscode == $model->accepted_hoscode): ?>
                <?php
                echo Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg> ยกเลิกการรับ', '#', [
                    'data-bs-toggle' => 'modal',
                    'data-bs-target' => '#rejectModal',
                    'class' => 'btn btn-light',
                ]);
                ?>
            <?php endif; ?>
             <button class='btn btn-light' onclick="window.print()"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg></button>
            <button onclick="window.close()" class="btn btn-light"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
           
        </div>
    </div>
    <hr class="no-print">
        <div>
            <!-- First Row -->
            <div class="row">
                <div class="col-md"><strong>รหัสหน่วยบริการ:</strong> <span class="pt"><?= $model->hoscode ?></span></div>
                <div class="col-md"><strong><?= $model->getAttributeLabel('hosname') ?>:</strong> <span class="pt"><?= $model->hosname ?></span></div>
            </div>
            <hr>

                <!-- Second Row -->
                <div class="row">
                    <div class="col-md"><strong>ชื่อ-นามสกุล ผู้ป่วย:</strong> <span class="pt"><?= $model->pname ?> <?= $model->fname ?> <?= $model->lname ?></span></div>

                    <div class="col-md"><strong>HN:</strong> <span class="pt"><?= $model->hn ?></span></div>
                    <div class="col-md"><strong>เลขบัตรปชช:</strong> <span class="pt"><?= $model->cid ?></span></div>
                </div>

                <!-- Fourth Row -->
                <div class="row">
                    <div class="col-md"><strong><?= $model->getAttributeLabel('gender') ?>:</strong> <span class="pt"><?= $model->gender ?></span></div>
                    <div class="col-md"><strong><?= $model->getAttributeLabel('birth_date') ?>:</strong> <span class="pt"><?= MyDate::toTh($model->birth_date) ?></span></div>
                    <div class="col-md"><strong>อายุ:</strong> <span class="pt"><?= $model->age_y ?>ปี <?= $model->age_m ?>เดือน</span></div>
                    <div class="col-md"><strong><?= $model->getAttributeLabel('occupat') ?>:</strong> 
                        <span class="pt"><?= ($model->coccupat) ? $model->coccupat->name : '-' ?></span>
                    </div>
                </div>
                <hr>

                    <p class="info">ที่อยู่ขณะป่วย:</p>
                    <div class="row">
                        <div class="col-md"><strong><?= $model->getAttributeLabel('prov') ?>:</strong> <span class="pt"><?= $model->prov ?></span></div>
                        <div class="col-md"><strong><?= $model->getAttributeLabel('amp') ?>:</strong> <span class="pt"><?= $model->camp->name ?></span></div>
                        <div class="col-md"><strong><?= $model->getAttributeLabel('tmb') ?>:</strong> <span class="pt"><?= $model->ctmb->name ?></span></div>
                    </div>

                    <!-- Seventh Row -->
                    <div class="row">
                        <div class="col-md"><strong><?= $model->getAttributeLabel('moo') ?>:</strong> <span class="pt"><?= substr($model->moo, 6, 2) ?>-<?= $model->cmoo->name ?></span></div>
                        <div class="col-md"><strong><?= $model->getAttributeLabel('street') ?>:</strong> <span class="pt"><?= $model->street ?></span></div>
                        <div class="col-md"><strong><?= $model->getAttributeLabel('place') ?>:</strong> <span class="pt"><?= $model->place ?></span></div>
                    </div>

                    <!-- Eighth Row -->
                    <div class="row">
                        <div class="col-md"><strong><?= $model->getAttributeLabel('addr') ?>:</strong> <span class="pt"><?= $model->addr ?></span></div>
                        <div class="col-md"><strong><?= $model->getAttributeLabel('tel') ?>:</strong> <span class="pt"><?= $model->tel ?></span></div>
                        <div class="col-md"><strong><?= $model->getAttributeLabel('family') ?>:</strong> <span class="pt"><?= $model->family ?></span></div>
                        <div class="col-md"><strong><?= $model->getAttributeLabel('addr_note') ?>:</strong> <span class="pt"><?= $model->addr_note ?></span></div>
                    </div>
                    <hr>

                        <p class="info">ข้อมูลการเจ็บป่วย:</p>
                        <!-- Ninth Row -->
                        <div class="row">
                            <div class="col-md"><strong><?= $model->getAttributeLabel('date_sick') ?>:</strong> <span class="pt"><?= MyDate::toTh($model->date_sick) ?></span></div>
                            <div class="col-md"><strong><?= $model->getAttributeLabel('date_visit') ?>:</strong> <span class="pt"><?= MyDate::toTh($model->date_visit) ?></span></div>
                            <div class="col-md"><strong><?= $model->getAttributeLabel('date_dx') ?>:</strong> <span class="pt"><?= MyDate::toTh($model->date_dx) ?></span></div>
                        </div>

                        <!-- Tenth Row -->
                        <div class="row">
                            <div class="col-md"><strong><?= $model->getAttributeLabel('symptom') ?>:</strong> <span class="pt"><?= $model->symptom ?></span></div>
                        </div>
                        <div class="row">
                            <div class="col-md"><strong><?= $model->getAttributeLabel('dx') ?>:</strong> <span class="pt"><?= "{$model->dx}-{$model->cdx->name}" ?></span></div>
                        </div>
                        <div class="row">
                            <div class="col-md"><strong><?= $model->getAttributeLabel('lab') ?>:</strong> <span class="pt"><?= $model->lab ?></span></div>
                        </div>

                        <!-- Eleventh Row -->
                        <div class="row">
                            <div class="col-md"><strong><?= $model->getAttributeLabel('doctor') ?>:</strong> <span class="pt"><?= $model->doctor ?></span></div>
                        </div>

                        <!-- Twelfth Row -->
                        <div class="row">
                            <div class="col-md"><strong><?= $model->getAttributeLabel('note') ?>:</strong> <span class="pt"><?= $model->note ?></span></div>
                        </div>
                        <hr>

                            <p class="info">ผู้แจ้งเคส:</p>
                            <!-- Thirteenth Row -->
                            <div class="row">
                                <div class="col-md"><strong>วันที่แจ้ง:</strong> <span class="pt"><?= $model->created_at ?></span></div>
                                <div class="col-md"><strong><?= $model->getAttributeLabel('reporter') ?>:</strong> <span class="pt"><?= $model->reporter ?></span></div>
                                <div class="col-md"><strong><?= $model->getAttributeLabel('reporter_position') ?>:</strong> <span class="pt"><?= $model->reporter_position ?></span></div>
                                <div class="col-md"><strong><?= $model->getAttributeLabel('reporter_tel') ?>:</strong> <span class="pt"><?= $model->reporter_tel ?></span></div>
                            </div>

                            <hr>
                                <p class="info">ผู้รับเคส:</p>
                                <!-- Fifteenth Row -->
                                <div class="row">
                                    <div class="col-md"><strong><span class="pt"><?= $model->accepted_hoscode ?>-<?= $model->accepted_hosname ?></span></strong></div>
                                    <div class="col-md"><strong><?= $model->getAttributeLabel('accepted_at') ?>:</strong> <span class="pt"><?= $model->accepted_at ?></span></div>
                                    <div class="col-md"><strong><?= $model->getAttributeLabel('accepted_note') ?>:</strong> <span class="pt"><?= $model->accepted_note ?></span></div>
                                </div>


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



                                <?php
                                Modal::begin([
                                    'id' => 'deleteModal',
                                    'title' => 'การยืนยันการลบ',
                                    'size' => 'md',
                                        //'footer' => '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>',
                                ]);
                                ?>

                                <div class="modal-body">
                                    <?php
                                    $form = ActiveForm::begin([
                                                'id' => 'modal-delete-form',
                                                'action' => ['delete', 'id' => $model->id],
                                                'method' => 'post',
                                    ]);
                                    ?>

                                    <?= Html::hiddenInput('id', $model->id) ?>
                                    <?= $form->field($model, 'deleted_note') ?>


                                    <div class="form-group">
                                        <?= Html::submitButton('ยืนยันการลบ', ['class' => 'btn btn-danger', 'id' => 'submitModalForm']) ?>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                    </div>

                                    <?php ActiveForm::end(); ?>
                                </div>

                                <?php Modal::end(); ?>

                                </div>