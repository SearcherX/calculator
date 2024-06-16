<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Журнал расчетов';
?>
<main>
    <div class="history">
        <div class="row">
            <h2 class="text-center"><?= Html::encode($this->title) ?></h2>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-bordered  mb-0 table-hover'],
                'rowOptions' => ['class' => 'mb3'],
                'layout' => "{pager}\n{summary}\n{items}",
                'pager' => [
                    'class' => 'yii\bootstrap5\LinkPager'
                ],
                'columns' => [
                    [
                        'attribute' => 'id',
                        'label' => 'ID',
                        'filter' => false,
                        'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],

                    ],
                [
                    'attribute' => 'user.email',
                    'label' => 'E-mail',
                    'visible' => Yii::$app->user->can('viewUsers'),
                    'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                ],
                    [
                        'attribute' => 'user.firstName',
                        'label' => 'Имя пользователя',
                    'visible' => Yii::$app->user->can('viewUsers'),
                        'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                    ],
                    [
                        'attribute' => 'raw_type',
                        'label' => 'Тип сырья',
                        'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],

                    ],
                    [
                        'attribute' => 'month',
                        'label' => 'Месяц',
                        'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                    ],
                    [
                        'attribute' => 'tonnage',
                        'label' => 'Тоннаж',
                        'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                    ],
                    [
                        'attribute' => 'price',
                        'label' => 'Стоимость доставки',
                        'filter' => false,
                        'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                    ],
                    [
                        'attribute' => 'created_at',
                        'value' => function ($data) {
                            return date('d.m.Y H:i:s', strtotime($data['created_at']));
                        },
                        'label' => 'Дата',
                        'sortLinkOptions' => ['class' => 'link-warning link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover'],
                    ],
//                [
//                    'class' => ActionColumn::class,
//                    'template' => '{delete}',
//                    'visible' => Yii::$app->user->can('administrator'),
//                ]
                ],
            ]) ?>
            <div class="modal fade text-dark" id="modalContent" tabindex="-1" aria-labelledby="modalContent"
                 aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalContentLabel">Информация</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body"></div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</main>