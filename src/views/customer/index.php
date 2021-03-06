<?php

use modava\customer\CustomerModule;
use modava\customer\widgets\NavbarWidgets;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\widgets\ToastrWidget;
use yii\widgets\Pjax;
use modava\auth\models\User;
use modava\customer\models\table\CustomerStatusDongYTable;
use modava\customer\models\table\CustomerStatusCallTable;

/* @var $this yii\web\View */
/* @var $searchModel modava\customer\models\search\CustomerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = CustomerModule::t('customer', 'Customers');
$this->params['breadcrumbs'][] = $this->title;
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $searchModel->toastr_key . '-index']) ?>
    <div class="container-fluid px-xxl-25 px-xl-10">
        <?= NavbarWidgets::widget(); ?>

        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
            </h4>
            <?php if (Yii::$app->user->can(User::DEV) ||
                Yii::$app->user->can('customer') ||
                Yii::$app->user->can('customerCustomerCreate')) { ?>
                <div class="mb-0">
                    <a class="btn btn-outline-light" href="<?= \yii\helpers\Url::to(['create']); ?>"
                       title="<?= CustomerModule::t('customer', 'Create'); ?> (Sales Online)">
                        <i class="fa fa-plus"></i> <?= CustomerModule::t('customer', 'Create'); ?></a>
                </div>
            <?php } ?>
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
                                            'code',
                                            [
                                                'attribute' => 'name',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return Html::a($model->name, ['view', 'id' => $model->primaryKey], []);
                                                }
                                            ],
                                            [
                                                'attribute' => 'phone',
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return $model->getPhone();
                                                }
                                            ],
                                            [
                                                'attribute' => 'status_call',
                                                'value' => function ($model) {
                                                    if ($model->statusCallHasOne == null) return null;
                                                    return $model->statusCallHasOne->name;
                                                }
                                            ],
                                            [
                                                'attribute' => 'status_fail',
                                                'value' => function ($model) {
                                                    if ($model->statusCallHasOne == null || $model->statusCallHasOne->accept == CustomerStatusCallTable::STATUS_PUBLISHED || $model->statusFailHasOne == null) return null;
                                                    return $model->statusFailHasOne->name;
                                                }
                                            ],
                                            [
                                                'attribute' => 'time_lich_hen',
                                                'value' => function ($model) {
                                                    if ($model->time_lich_hen == null) return null;
                                                    return date('H:i d-m-Y', $model->time_lich_hen);
                                                }
                                            ],
                                            [
                                                'attribute' => 'status_dat_hen',
                                                'value' => function ($model) {
                                                    if ($model->statusCallHasOne == null || $model->statusCallHasOne->accept != CustomerStatusCallTable::STATUS_PUBLISHED ||
                                                        $model->statusDatHenHasOne == null) return null;
                                                    return $model->statusDatHenHasOne->name;
                                                }
                                            ],
                                            [
                                                'attribute' => 'status_dong_y',
                                                'value' => function ($model) {
                                                    if ($model->statusDongYHasOne == null) return null;
                                                    return $model->statusDongYHasOne->name;
                                                }
                                            ],
                                            [
                                                'attribute' => 'status_dong_y_fail',
                                                'value' => function ($model) {
                                                    if ($model->statusDongYFailHasOne == null) return null;
                                                    return $model->statusDongYFailHasOne->name;
                                                }
                                            ],
                                            [
                                                'attribute' => 'permission_user',
                                                'value' => function ($model) {
                                                    if ($model->type != \modava\customer\models\Customer::TYPE_ONLINE) return null;
                                                    return $model->permissionUserHasOne->userProfile->fullname;
                                                }
                                            ],
                                            [
                                                'attribute' => 'direct_sale',
                                                'value' => function ($model) {
                                                    if ($model->directSaleHasOne == null) return null;
                                                    return $model->directSaleHasOne->userProfile->fullname;
                                                }
                                            ],
                                            'sale_online_note',
                                            'direct_sale_note',
                                            [
                                                'class' => 'yii\grid\ActionColumn',
                                                'header' => CustomerModule::t('customer', 'Actions'),
                                                'template' => '<div>{update} {delete}</div><div class="mt-1">{create-order} {list-order}</div>',
                                                'buttons' => [
                                                    'update' => function ($url, $model) {
                                                        if (Yii::$app->user->can(User::DEV) ||
                                                            Yii::$app->user->can('customer') ||
                                                            Yii::$app->user->can('customerCustomerUpdate')) {
                                                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                                                'title' => CustomerModule::t('customer', 'Update'),
                                                                'alia-label' => CustomerModule::t('customer', 'Update'),
                                                                'data-pjax' => 0,
                                                                'class' => 'btn btn-info btn-xs'
                                                            ]);
                                                        }
                                                        return null;
                                                    },
                                                    'delete' => function ($url, $model) {
                                                        if (Yii::$app->user->can(User::DEV) ||
                                                            Yii::$app->user->can('customer') ||
                                                            Yii::$app->user->can('customerCustomerDelete')) {
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
                                                        }
                                                        return null;
                                                    },
                                                    'create-order' => function ($url, $model) {
                                                        if (Yii::$app->user->can(User::DEV) ||
                                                            Yii::$app->user->can('customer') ||
                                                            Yii::$app->user->can('customerCustomer-orderCreate')) {
                                                            if ($model->statusDongYHasOne == null || $model->statusDongYHasOne->accept != CustomerStatusDongYTable::STATUS_PUBLISHED) return null;
                                                            return Html::a('<span class="glyphicon glyphicon-plus"></span>', ['/customer/customer-order/create', 'customer_id' => $model->id], [
                                                                'title' => CustomerModule::t('customer', 'Create Cart'),
                                                                'alia-label' => CustomerModule::t('customer', 'Create Cart'),
                                                                'data-pjax' => 0,
                                                                'class' => 'btn btn-success btn-xs'
                                                            ]);
                                                        }
                                                        return null;
                                                    },
                                                    'list-order' => function ($url, $model) {
                                                        if (Yii::$app->user->can(User::DEV) ||
                                                            Yii::$app->user->can('customer') ||
                                                            Yii::$app->user->can('customerCustomer-orderIndex')) {
                                                            if ($model->statusDongYHasOne == null || $model->statusDongYHasOne->accept != CustomerStatusDongYTable::STATUS_PUBLISHED) return null;
                                                            return Html::a('<span class="glyphicon glyphicon-shopping-cart"></span>', ['/customer/customer-order/index', 'customer_id' => $model->id], [
                                                                'title' => CustomerModule::t('customer', 'List Cart'),
                                                                'alia-label' => CustomerModule::t('customer', 'List Cart'),
                                                                'data-pjax' => 0,
                                                                'class' => 'btn btn-success btn-xs'
                                                            ]);
                                                        }
                                                        return null;
                                                    },
                                                ],
                                                'headerOptions' => [
                                                    'width' => 120,
                                                ],
                                                'contentOptions' => [
                                                    'class' => 'text-center'
                                                ]
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