<?php

use modava\customer\CustomerModule;
use modava\customer\widgets\NavbarWidgets;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\widgets\ToastrWidget;
use yii\widgets\Pjax;
use modava\customer\models\table\CustomerOrderTable;

/* @var $this yii\web\View */
/* @var $searchModel modava\customer\models\search\CustomerOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = CustomerModule::t('customer', 'Đơn hàng');
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
            <a class="btn btn-outline-light" href="<?= \yii\helpers\Url::to(['create']); ?>"
               title="<?= CustomerModule::t('customer', 'Create'); ?>">
                <i class="fa fa-plus"></i> <?= CustomerModule::t('customer', 'Create'); ?></a>
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
                                                'attribute' => 'customer_id',
                                                'format' => 'html',
                                                'label' => CustomerModule::t('customer', 'Customers'),
                                                'value' => function ($model) {
                                                    return Html::a($model->customerHasOne->name, ['view', 'id' => $model->id], []);
                                                }
                                            ],
                                            [
                                                'attribute' => 'code',
                                                'label' => CustomerModule::t('customer', 'Order'),
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return Html::a($model->code, ['view', 'id' => $model->id], [
                                                        'data-pjax' => 0
                                                    ]);
                                                }
                                            ],
                                            'total',
                                            'discount',
                                            //'co_so',
                                            //'ordered_at',
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
                                                'template' => '<div>{update} {delete}</div><div class="mt-1">{payment} {list-payment}</div>',
                                                'buttons' => [
                                                    'update' => function ($url, $model) {
                                                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                                            'title' => CustomerModule::t('customer', 'Update'),
                                                            'alia-label' => CustomerModule::t('customer', 'Update'),
                                                            'data-pjax' => 0,
                                                            'class' => 'btn btn-info btn-xs'
                                                        ]);
                                                    },
                                                    'delete' => function ($url, $model) {
                                                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'javascript:;', [
                                                            'title' => CustomerModule::t('customer', 'Delete'),
                                                            'class' => 'btn btn-danger btn-xs btn-del',
                                                            'data-title' => CustomerModule::t('customer', 'Delete?'),
                                                            'data-pjax' => 0,
                                                            'data-url' => $url,
                                                            'btn-success-class' => 'success-delete',
                                                            'btn-cancel-class' => 'cancel-delete',
                                                            'data-placement' => 'top'
                                                        ]);
                                                    },
                                                    /*
                                                     * Lịch điều trị
                                                     * 'treatment-schedule' => function ($url, $model) {
                                                        if ($model->status == CustomerOrderTable::STATUS_PUBLISHED) return null;
                                                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', ['/customer/customer-treatment-schedule/create', 'order_id' => $model->id], [
                                                            'title' => CustomerModule::t('customer', 'Create Treatment Schedule'),
                                                            'class' => 'btn btn-warning btn-xs',
                                                            'data-pjax' => 0,
                                                        ]);
                                                    },
                                                    'list-treatment-schedule' => function ($url, $model) {
                                                        return Html::a('<span class="glyphicon glyphicon-list-alt"></span>', ['/customer/customer-treatment-schedule/index', 'order_id' => $model->id], [
                                                            'title' => CustomerModule::t('customer', 'List Treatment Schedule'),
                                                            'class' => 'btn btn-warning btn-xs',
                                                            'data-pjax' => 0,
                                                        ]);
                                                    },*/
                                                    'payment' => function ($url, $model) {
                                                        if ($model->status == CustomerOrderTable::STATUS_PUBLISHED) return null;
                                                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', ['/customer/customer-payment/create', 'order_id' => $model->id], [
                                                            'title' => CustomerModule::t('customer', 'Create Payment'),
                                                            'class' => 'btn btn-success btn-xs',
                                                            'data-pjax' => 0,
                                                        ]);
                                                    },
                                                    'list-payment' => function ($url, $model) {
                                                        return Html::a('<span class="glyphicon glyphicon-credit-card"></span>', ['/customer/customer-payment/index', 'order_id' => $model->id], [
                                                            'title' => CustomerModule::t('customer', 'List Payment'),
                                                            'class' => 'btn btn-success btn-xs',
                                                            'data-pjax' => 0,
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
$('body').on('click', '.success-delete', function(e){
    e.preventDefault();
    var url = $(this).attr('href') || null;
    if(url !== null){
        $.post(url);
    }
    return false;
});
JS;
$this->registerJs($script, \yii\web\View::POS_END);