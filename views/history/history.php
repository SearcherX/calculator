<?php

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Журнал расчетов';
?>
    <main>
        <div class="history mt-2">
            <div class="row px-5">
                <h2 class="text-center"><?= Html::encode($this->title) ?></h2>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'table table-bordered table-hover'],
                    'layout' => "{pager}\n{summary}\n{items}",
                    'pager' => [
                        'class' => 'yii\bootstrap5\LinkPager'
                    ],
                    'columns' => [
                        [
                            'attribute' => 'id',
                            'label' => 'ID',
                            'filter' => false,
                            'sortLinkOptions' => ['class' => 'app-link link-offset-2 link-underline-opacity-25 
                            link-underline-opacity-100-hover'],

                        ],
                        [
                            'attribute' => 'email',
                            'label' => 'E-mail',
                            'value' => 'user.email',
                            'visible' => Yii::$app->user->can('viewProfile'),
                            'sortLinkOptions' => ['class' => 'app-link link-offset-2 link-underline-opacity-25 
                            link-underline-opacity-100-hover'],
                        ],
                        [
                            'attribute' => 'username',
                            'value' => 'user.username',
                            'label' => 'Имя пользователя',
                            'visible' => Yii::$app->user->can('viewProfile'),
                            'sortLinkOptions' => ['class' => 'app-link link-offset-2 link-underline-opacity-25 
                            link-underline-opacity-100-hover'],
                        ],
                        [
                            'attribute' => 'raw_type',
                            'label' => 'Тип сырья',
                            'value' => function ($data) {
                                return mb_convert_case($data->raw_type, MB_CASE_TITLE, 'UTF-8');
                            },
                            'sortLinkOptions' => ['class' => 'app-link link-offset-2 link-underline-opacity-25 
                            link-underline-opacity-100-hover'],

                        ],
                        [
                            'attribute' => 'month',
                            'label' => 'Месяц',
                            'value' => function ($data) {
                                return mb_convert_case($data->month, MB_CASE_TITLE, 'UTF-8');
                            },
                            'sortLinkOptions' => ['class' => 'app-link link-offset-2 link-underline-opacity-25 
                            link-underline-opacity-100-hover'],
                        ],
                        [
                            'attribute' => 'tonnage',
                            'label' => 'Тоннаж',
                            'sortLinkOptions' => ['class' => 'app-link link-offset-2 link-underline-opacity-25 
                            link-underline-opacity-100-hover'],
                        ],
                        [
                            'attribute' => 'price',
                            'label' => 'Стоимость доставки',
                            'sortLinkOptions' => ['class' => 'app-link link-offset-2 link-underline-opacity-25 
                            link-underline-opacity-100-hover'],
                        ],
                        [
                            'attribute' => 'created_at',
                            'value' => function ($data) {
                                return date('d.m.Y H:i:s', strtotime($data['created_at']));
                            },
                            'label' => 'Дата',
                            'sortLinkOptions' => ['class' => 'app-link link-offset-2 link-underline-opacity-25 
                            link-underline-opacity-100-hover'],
                        ],
                        [
                            'class' => ActionColumn::class,
                            'template' => '{delete}',
                            'visible' => Yii::$app->user->can('viewHistory'),
                        ]
                    ],
                ]) ?>
                <div class="modal fade text-dark" id="modalContent" tabindex="-1" aria-labelledby="modalContent"
                     aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalContentLabel">Информация</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body"></div>

                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

<?php
$js = <<<JS

    $('.grid-view tbody tr td:not(:last-child)').on('click', function (){
        let data = $(this).closest('tr').attr('data-key')
        let modal = $('#modalContent');
        
        modal.find('.modal-title').text('ID расчёта: ' +data)
        modal.find('.modal-body').load('/history/view?id=' + data, function() {
        })
        $('.modal-footer').find('input').attr('form','update-profile-form')
        modal.modal('show')
        return false;
    })
JS;
$this->registerJs($js);
?>