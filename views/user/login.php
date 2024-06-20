<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Авторизация"
?>

<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 border rounded-3 p-4 shadow">
                <h3 class="text-center mb-3"><?= Html::encode($this->title) ?></h3>
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'fieldConfig' => [
                        'errorOptions' => ['class' => 'text-danger']
                    ]
                ]) ?>
                <div class="mb-3 required">
                <?= $form->field($model, 'email')
                    ->textInput(['autofocus' => true, 'placeholder' => 'Email', 'autocomplete' => 'current-email',
                        'class' => 'app-form-control form-control'])
                    ->label(false) ?>
                </div>
                <div class="mb-3 required">
                <?= $form->field($model, 'password')
                    ->passwordInput(['placeholder' => 'Пароль', 'autocomplete' => 'current-password',
                        'class' => 'app-form-control form-control'])
                    ->label(false) ?>
                </div>
                <div class="d-grid gap-2 mb-3">
                    <?= Html::submitButton('Войти', [
                        'class' => 'btn btn-block app-btn',
                        'name' => 'user-button'
                    ]) ?>
                </div>
                <?php ActiveForm::end(); ?>
                <div>
                    <p class="mb-0 text-end">Нет аккаунта? <?= Html::a(
                            'Зарегистрируйтесь', ['user/signup'], ['class' => 'fw-bold app-link']
                        ) ?>
                    </p>
                </div>

            </div>
        </div>
    </div>
</main>
