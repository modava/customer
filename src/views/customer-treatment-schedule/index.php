<?php

use modava\customer\CustomerModule;
use modava\customer\widgets\NavbarWidgets;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\widgets\ToastrWidget;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel modava\customer\models\search\CustomerTreatmentScheduleSeach */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = CustomerModule::t('customer', 'Customer Treatment Schedules');
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
            <a class="btn btn-outline-light"
               href="<?= \yii\helpers\Url::to(['create', 'order_id' => Yii::$app->request->get('order_id')]); ?>"
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
                                                'attribute' => 'orderHasOne.customerHasOne.name',
                                                'label' => CustomerModule::t('customer', 'Customer ID'),
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return Html::a($model->orderHasOne->customerHasOne->name, ['/customer/clinic/view', 'id' => $model->orderHasOne->customerHasOne->id], [
                                                        'target' => '_blank',
                                                        'data-pjax' => 0
                                                    ]);
                                                }
                                            ],
                                            [
                                                'attribute' => 'orderHasOne.code',
                                                'label' => CustomerModule::t('customer', 'Order ID'),
                                                'format' => 'raw',
                                                'value' => function ($model) {
                                                    return Html::a($model->orderHasOne->code, ['/customer/customer-order/view', 'id' => $model->orderHasOne->id], [
                                                        'target' => '_blank',
                                                        'data-pjax' => 0
                                                    ]);
                                                }
                                            ],
                                            'co_so',
                                            'time_start:datetime',
                                            'time_end:datetime',
                                            'note',
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
                                                'template' => '{view} {update} {delete}',
                                                'buttons' => [
                                                    'view' => function ($url, $model) {
                                                        return Html::a('<span class="glyphicon glyphicon-search"></span>', $url, [
                                                            'title' => CustomerModule::t('customer', 'View'),
                                                            'alia-label' => CustomerModule::t('customer', 'View'),
                                                            'data-pjax' => 0,
                                                            'class' => 'btn btn-success btn-xs'
                                                        ]);
                                                    },
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
                                                    }
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