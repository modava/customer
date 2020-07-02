<?php

use modava\customer\CustomerModule;
use modava\customer\widgets\NavbarWidgets;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\widgets\ToastrWidget;
use yii\widgets\Pjax;
use modava\customer\models\table\CustomerTable;

/* @var $this yii\web\View */
/* @var $searchModel modava\customer\models\search\RemindCallSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = CustomerModule::t('customer', 'Nhắc lịch chăm sóc');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $searchModel->toastr_key . '-index']) ?>
    <div class="container-fluid px-xxl-25 px-xl-10">
        <?= NavbarWidgets::widget(); ?>

        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                            class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
            </h4>
        </div>

        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <section class="hk-sec-wrapper">

                    <?php Pjax::begin(); ?>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <div class="dataTables_wrapper dt-bootstrap4">
                                    <?= GridView::widget([
                                        'dataProvider' => $dataProvider,
                                        'layout' => '
                                            {errors}
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    {items}
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-5">
                                                    <div class="dataTables_info" role="status" aria-live="polite">
                                                        {pager}
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-7">
                                                    <div class="dataTables_paginate paging_simple_numbers">
                                                        {summary}
                                                    </div>
                                                </div>
                                            </div>
                                        ',
                                        'pager' => [
                                            'firstPageLabel' => CustomerModule::t('customer', 'First'),
                                            'lastPageLabel' => CustomerModule::t('customer', 'Last'),
                                            'prevPageLabel' => CustomerModule::t('customer', 'Previous'),
                                            'nextPageLabel' => CustomerModule::t('customer', 'Next'),
                                            'maxButtonCount' => 5,

                                            'options' => [
                                                'tag' => 'ul',
                                                'class' => 'pagination',
                                            ],

                                            // Customzing CSS class for pager link
                                            'linkOptions' => ['class' => 'page-link'],
                                            'activePageCssClass' => 'active',
                                            'disabledPageCssClass' => 'disabled page-disabled',
                                            'pageCssClass' => 'page-item',

                                            // Customzing CSS class for navigating link
                                            'prevPageCssClass' => 'paginate_button page-item',
                                            'nextPageCssClass' => 'paginate_button page-item',
                                            'firstPageCssClass' => 'paginate_button page-item',
                                            'lastPageCssClass' => 'paginate_button page-item',
                                        ],
                                        'rowOptions' => function ($model, $index) {
                                            if (date('d-m-Y', $model->remind_call_time) == date('d-m-Y')) return [
                                                'class' => 'table-danger'
                                            ];
                                            return [];
                                        },
                                        'columns' => [
                                            [
                                                'class' => 'yii\grid\SerialColumn',
                                                'header' => 'STT',
                                                'headerOptions' => [
                                                    'width' => 60,
                                                    'rowspan' => 2
                                                ],
                                                'filterOptions' => [
                                                    'class' => 'd-none',
                                                ],
                                            ],
                                            [
                                                'attribute' => 'name',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return Html::a($model->name, ['/customer/customer/view', 'id' => $model->id], []);
                                                }
                                            ],
                                            'phone',
                                            [
                                                'attribute' => 'remind_call_time',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    if ($model->remind_call_time == null) return null;
                                                    return date('d-m-Y H:i', $model->remind_call_time);
                                                }
                                            ],
                                            [
                                                'attribute' => 'created_by',
                                                'value' => 'userCreated.userProfile.fullname',
                                                'headerOptions' => [
                                                    'width' => 150,
                                                ],
                                            ],
                                            [
                                                'attribute' => 'created_at',
                                                'format' => 'date',
                                                'headerOptions' => [
                                                    'width' => 150,
                                                ],
                                            ],
                                            [
                                                'class' => 'yii\grid\ActionColumn',
                                                'header' => CustomerModule::t('customer', 'Actions'),
                                                'template' => '{update}',
                                                'buttons' => [
                                                    'update' => function ($url, $model) {
                                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['/customer/customer/update', 'id' => $model->id], [
                                                            'title' => CustomerModule::t('customer', 'Update'),
                                                            'alia-label' => CustomerModule::t('customer', 'Update'),
                                                            'data-pjax' => 0,
                                                            'class' => 'btn btn-info btn-xs'
                                                        ]);
                                                    },
                                                ],
                                                'headerOptions' => [
                                                    'width' => 150,
                                                ],
                                            ],
                                        ],
                                    ]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php Pjax::end(); ?>
                </section>
            </div>
        </div>
    </div>
<?php
$script = <<< JS
JS;
$this->registerJs($script, \yii\web\View::POS_END);