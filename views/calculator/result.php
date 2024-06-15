<?php

use app\helpers\RenderHelper;

?>

<div id="result" class=" mb-4">
    <div class="row justify-content-center mt-5 ">
        <div class="col-md-3 me-3 ">
            <div class="card shadow-lg ">
                <div class="card-header bg-success text-white fw-bold fs-6 ">Введённые данные:</div>
                <ul class="list-group list-group-flush ">
                    <li class="list-group-item ">
                        <strong>Месяц: </strong>
                        <?= mb_convert_case($form_model->month, MB_CASE_TITLE, 'UTF-8') ?>
                    </li>
                    <li class="list-group-item ">
                        <strong>Тоннаж: </strong>
                        <?= $form_model->tonnage ?>
                    </li>
                    <li class="list-group-item ">
                        <strong>Тип сырья: </strong>
                        <?= mb_convert_case($form_model->raw_type, MB_CASE_TITLE, 'UTF-8') ?>
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
                        <?php foreach ($headTableTM as $tonnage): ?>
                            <td class="<?= RenderHelper::getBorderClass(
                                        $month, $tonnage, $form_model->month, $form_model->tonnage
                                    ) ?>">
                                <?= $tonnages[$tonnage] ?? '' ?>
                            </td>
                        <?php endforeach ?>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>