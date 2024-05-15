<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

const PROJECT_ROOT = __DIR__ . "/../../";
include_once PROJECT_ROOT . "utils/utils.php";

$lists = require_once PROJECT_ROOT . "config/lists.php";
$prices = require_once PROJECT_ROOT . "config/prices.php";
?>

<main class="main" class="flex-shrink-0" role="main" ">
<div class=" container " id=" main-block ">
    <div class=" text-center mb-4 mt-3 ">
        <h1>Калькулятор стоимости доставки сырья</h1>
    </div>

    <div class=" row justify-content-center ">
        <div class=" col-md-6 border rounded-3 p-4 shadow ">
            <?php
            $form = ActiveForm::begin() ?>
            <div class=" mb-3 required ">
                <?= $form->field($form_model, 'month')->dropDownList(
                    $monthsList,
                    [
                        'prompt' => [
                            'text' => 'Выберите параметр',
                            'options' => ['disabled' => true, 'selected' => true]
                        ],
                        'class' => 'form-select'
                    ]
                )->label('Месяц', ['class' => 'form-label']) ?>
            </div>
            <div class=" mb-3 required ">
                <?= $form->field($form_model, 'tonnage')->dropDownList(
                    $tonnagesList,
                    [
                        'prompt' => [
                            'text' => 'Выберите параметр',
                            'options' => ['disabled' => true, 'selected' => true]
                        ],
                        'class' => 'form-select'
                    ]
                )->label('Тоннаж') ?>
            </div>
            <div class=" mb-3 required ">
                <?= $form->field($form_model, 'raw_type')->dropDownList(
                    $raw_typesList,
                    [
                        'prompt' => [
                            'text' => 'Выберите параметр',
                            'options' => ['disabled' => true, 'selected' => true]
                        ],
                        'class' => 'form-select'
                    ]
                )->label('Тип сырья') ?>
            </div>
            <?= Html::submitButton('Рассчитать', ['class' => 'btn btn-success']) ?>
            <a href=" / " type=" button " class=" btn btn-danger ">Сброс</a>
            <?php ActiveForm::end() ?>
        </div>
    </div>

    <?php if (empty($_POST) === false): ?>

        <div id=" result " class=" mb-4">
            <div class="row justify-content-center mt-5 ">
                <div class="col-md-3 me-3 ">
                    <div class="card shadow-lg ">
                        <div class="card-header bg-success text-white fw-bold fs-6 ">Введённые данные:</div>
                        <ul class="list-group list-group-flush ">
                            <li class="list-group-item ">
                                <strong>Месяц: </strong>
                                <?= $selectedMonth ?>
                            </li>
                            <li class="list-group-item ">
                                <strong>Тоннаж: </strong>
                                <?= $selectedTonnage ?>
                            </li>
                            <li class="list-group-item ">
                                <strong>Тип сырья: </strong>
                                <?= $selectedRaw_type ?>
                            </li>
                            <li class="list-group-item ">
                                <strong>Итог, руб.: </strong>
                                <?= $price ?>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 table-responsive border rounded-1 shadow-lg p-0 ">
                    <table class="table table-hover table-striped text-center mb-0 ">
                        <thead>
                        <tr>
                            <th>Т/М</th>
                            <?php foreach ($headTableTM as $tonnagePrices): ?>
                                <th><?= $tonnagePrices ?></th>
                            <?php endforeach ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($bodyTableTM as $month => $tonnages): ?>
                            <tr>
                                <td><?= mb_convert_case($month, MB_CASE_TITLE, 'UTF-8') ?></td>
                                <?php foreach ($tonnages as $tonnage => $price) { ?>
                                    <td
                                            class="<?= getBorderClass(
                                                $month, $tonnage, $selectedMonth, $selectedTonnage
                                            ) ?>">
                                        <?= $price ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <?php endif ?>

</div>
</main>