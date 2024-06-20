<?php

?>

<div>
    <div class="mb-2">
        <?php

        if (Yii::$app->user->can('viewHistory')): ?>
            <p>Имя пользователя: <?= $model->user->username ?></p>
            <p>Email: <?= $model->user->email ?></p>
        <?php endif; ?>

        <p>Дата выполнения расчёта: <?= date('d.m.Y H:i:s', strtotime($model->getCalculationDate())) ?></p>
    </div>

    <?= $this->render('../calculator/result', [
        'model' => $model,
        'price' => $model->price,
        'dataProvider' => $dataProvider
    ]) ?>
</div>
