<?php

use yii\helpers\Html;

$this->title = 'Информация';
?>

<main>
    <div class="calculator-profile">
        <h2 class="text-center"><?= Html::encode($this->title) ?></h2>


        <div class="container py-4">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <img src=
                                 "<?= Yii::$app->authManager->checkAccess($model->id, 'viewProfile') ?
                                     'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1.webp' :
                                     'https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp' ?>"
                                 alt="avatar"
                                 class="rounded-circle img-fluid" style="width: 150px;">
                            <h5 class="my-3"><?= $model->username ?></h5>
                            <p class="text-muted mb-2"><?= Yii::$app->authManager->checkAccess($model->id, 'viewProfile') ? 'Администратор' : 'Пользователь' ?></p>
                            <?php if ($model->id === Yii::$app->user->id): ?>
                                <?= Html::a('Журнал расчётов', ['../history'], ['class' => 'btn btn-primary mb-2']) ?>
                                <?= Html::beginForm(['user/logout']) . Html::submitButton('Выход', ['class' => 'btn btn-danger']) . Html::endForm() ?>
                            <?php endif; ?>
                        </div>

                    </div>

                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Имя</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $model->username ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $model->email ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">ID</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $model->id ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Дата регистрации</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= date('d.m.Y', strtotime($model->getRegistrationData())) ?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Количество расчётов</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0"><?= $model->getCalculationsCount() ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</main>
