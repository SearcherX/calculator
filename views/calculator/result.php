<?php

use app\helpers\RenderHelper;

?>

<div id="result" class="mb-4">
    <div class="row justify-content-center <?= isset($model->price) ? 'flex-column align-items-center' : 'mt-4' ?>">
        <div class="<?= isset($model->price) ? 'col-6' : 'col-3' ?>">
            <div class="card shadow">
                <div class="card-header bg-success text-white fw-bold fs-6 ">Введённые данные:</div>
                <ul class="list-group list-group-flush ">
                    <li class="list-group-item ">
                        <strong>Месяц: </strong>
                        <?= mb_convert_case($model->month, MB_CASE_TITLE, 'UTF-8') ?>
                    </li>
                    <li class="list-group-item ">
                        <strong>Тоннаж: </strong>
                        <?= $model->tonnage ?>
                    </li>
                    <li class="list-group-item ">
                        <strong>Тип сырья: </strong>
                        <?= mb_convert_case($model->raw_type, MB_CASE_TITLE, 'UTF-8') ?>
                    </li>
                    <li class="list-group-item ">
                        <strong>Итог, руб.: </strong>
                        <?= $price ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="<?= isset($model->price) ? 'col-9 mt-3' : 'col-6' ?> table-responsive border rounded-1 shadow-lg p-0">
            <table class="table table-hover table-striped text-center">
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
                        <?php foreach ($tonnages as $tonnage => $price): ?>
                            <td class="<?= RenderHelper::getBorderClass(
                                $month, $tonnage, $model->month, $model->tonnage
                            ) ?>">
                                <?= $price ?>
                            </td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>