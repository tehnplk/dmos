<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .groupbox {
        border: 2px solid #ccc;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
        position: relative;
        width: 50%
    }

    .groupbox-title {
        position: absolute;
        top: -12px;
        left: 15px;
        background-color: #f9f9f9;
        padding: 0 10px;
        font-weight: bold;
        color: #333;
    }

    .groupbox-content {
        padding-top: 10px; /* To add space below the title */
    }

</style>
<div class="container site-login">




    <div class="d-flex flex-row gap-2" >

        <div class="groupbox">
            <div class="groupbox-title">เข้าระบบด้วย USER เดิม</div>
            <div class="groupbox-content">
                <!-- Content goes here -->
                <div>

                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'login-form',
                                'fieldConfig' => [
                                    'template' => "{label}\n{input}\n{error}",
                                    //'labelOptions' => ['class' => 'col-form-label mr-lg-3'],
                                    'inputOptions' => ['class' => 'form-control'],
                                    'errorOptions' => ['class' => 'invalid-feedback'],
                                ],
                    ]);
                    ?>

                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput() ?>

                    <?php
                    echo $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    ])
                    ?>

                    <div class="form-group">
                        <div>
                            <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>



                </div>
            </div>
        </div>



        <div class="groupbox">
            <div class="groupbox-title">เข้าระบบด้วย Provider Id</div>
            <div class="groupbox-content">
                <!-- Content goes here -->
                <div>
                    <?php
                    echo Html::a(Html::img('@web/pic/provider_id.png', ['width' => 250, 'heigth' => 250]), '#', ['onclick' => 'alert("อยู่ระหว่างพัฒนา..")']);
                    ?>
                </div>
            </div>
        </div>


    </div>
</div>
