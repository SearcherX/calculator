<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<?php if (Yii::$app->session->hasFlash('success-login')): ?>
    <?php $arr = array_reverse(Yii::$app->authManager->getRolesByUser(Yii::$app->user->getId())) ?>

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Здравствуйте, <?= array_pop($arr)->description ?>&nbsp
        <strong><?= Yii::$app->session->getFlash('success-login') ?></strong>, вы авторизовались в системе
        расчета стоимости доставки. Теперь все ваши расчеты будут сохранены для последующего просмотра в
        <a href="/history" class="app-link">журнале расчетов</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php endif; ?>

<main class="main flex-shrink-0" role="main" ">
<div class=" container " id="main-block">
    <div class=" text-center mb-4 mt-3 ">
        <h1>Калькулятор стоимости доставки сырья</h1>
    </div>

    <div class=" row justify-content-center ">
        <div class=" col-md-6 border rounded-3 p-4 shadow ">
            <?php $form = ActiveForm::begin([
                'id' => 'calc-form',
                'enableAjaxValidation' => true,
                'validationUrl' => Url::to(['calculator/validate']),
                'fieldConfig' => [
                    'errorOptions' => ['class' => 'text-danger']
                ]
            ]) ?>
            <div class=" mb-3 required ">
                <?= $form->field($model, 'month')->dropDownList(
                    $months,
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
                <?= $form->field($model, 'tonnage')->dropDownList(
                    $tonnages,
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
                <?= $form->field($model, 'raw_type')->dropDownList(
                    $types,
                    [
                        'prompt' => [
                            'text' => 'Выберите параметр',
                            'options' => ['disabled' => true, 'selected' => true]
                        ],
                        'class' => 'form-select'
                    ]
                )->label('Тип сырья') ?>
            </div>
            <?= Html::submitButton('Рассчитать', ['class' => 'btn btn-success', 'id' => 'calc-btn']) ?>
            <a href=" / " type=" button " class=" btn btn-danger ">Сброс</a>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
</main>

<?php
$js = <<<JS
    let form = $('#calc-form');
    form.on('beforeSubmit', function () {
        let data = form.serialize();
        $.ajax({
            url: '/calculator',
            data: data,
            type: 'POST',
            success: function(response) {
                $('#result').remove();
                $('#alert-error').remove();
                $('#main-block').append(response)
            }
        })
        return false;
    })
JS;

$this->registerJs($js);
?>


<!--CalculatorForm[raw_type]=%D1%88%D1%80%D0%BE%D1%82&CalculatorForm[tonnage]=25&CalculatorForm[month]=%D1%8F%D0%BD%D0%B2%D0%B0%D1%80%D1%8C&_csrf=Cqv2ltxfqZfwPD2poMcEpmkpyykTaxSVNkYAg-7MLoY96p-gtS3q7ZIMCZ_0smPCLXOlWHY0Zt10dDjSvIF7yw%3D%3D-->

<!--_csrf=2SsHspsoLBhj30S0vOfNU664cYTKokBDE81KIA7xd3_uam6E8lpvYgHvcILokqo36uIf9a_9MgtR_3JxXLwiMg%3D%3D&CalculatorForm%5Bmonth%5D=%D1%8F%D0%BD%D0%B2%D0%B0%D1%80%D1%8C&CalculatorForm%5Btonnage%5D=25&CalculatorForm%5Braw_type%5D=%D1%88%D1%80%D0%BE%D1%82-->

