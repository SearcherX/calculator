<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = "Регистрация"
?>

<main class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 border rounded-3 p-4 shadow">
                <div class="login-wrap p-4 p-md-5">
                    <h2 class="text-center mb-4"><?= Html::encode($this->title) ?></h2>
                    <?php $form = ActiveForm::begin([
                        'id' => 'user-form',
                        'enableAjaxValidation' => false,
                        'validationUrl' => Url::toRoute('/user/signup-validation')
                    ]); ?>
                    <div class="mb-3 required ">
                        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => "Email", 'autocomplete' => 'new-email'])->label(false) ?>
                    </div>
                    <div class="mb-3 required ">
                        <?= $form->field($model, 'firstName')->textInput(['placeholder' => "Имя"])->label(false) ?>
                    </div>
                    <div class="mb-3 required ">
                        <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control', 'placeholder' => 'Пароль', 'autocomplete' => 'new-password']) ?>
                    </div>
                    <div class="mb-3 required ">
                        <?= $form->field($model, 'repeatPassword')->passwordInput(['placeholder' => "Повторите пароль"])->label(false) ?>
                    </div>
                    <hr>
                    <div class="d-grid gap-2 mb-3">
                        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-warning  btn-block ', 'name' => 'user-button']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</main>
