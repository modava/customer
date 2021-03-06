<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\widgets\ToastrWidget;
use modava\customer\widgets\NavbarWidgets;
use modava\customer\CustomerModule;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\CustomerTreatmentSchedule */

$this->title = CustomerModule::t('customer', 'Customer Treatment Schedules') . ': ' . $model->orderHasOne->customerHasOne->name . ' (' . $model->orderHasOne->code . ')';
$this->params['breadcrumbs'][] = ['label' => CustomerModule::t('customer', 'Customer Treatment Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-view']) ?>
<div class="container-fluid px-xxl-25 px-xl-10">
    <?= NavbarWidgets::widget(); ?>

    <!-- Title -->
    <div class="hk-pg-header">
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span
                        class="ion ion-md-apps"></span></span><?= Html::encode($this->title) ?>
        </h4>
        <p>
            <a class="btn btn-outline-light" href="<?= Url::to(['create']); ?>"
               title="<?= CustomerModule::t('customer', 'Create'); ?>">
                <i class="fa fa-plus"></i> <?= CustomerModule::t('customer>', 'Create'); ?></a>
            <?= Html::a(CustomerModule::t('customer>', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(CustomerModule::t('customer>', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => CustomerModule::t('customer', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </p>
    </div>
    <!-- /Title -->

    <!-- Row -->
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id',
                        [
                            'attribute' => 'orderHasOne.customerHasOne.name',
                            'label' => CustomerModule::t('customer', 'Customer ID'),
                            'format' => 'raw',
                            'value' => function ($model) {
                                return Html::a($model->orderHasOne->customerHasOne->name, ['/customer/customer/view', 'id' => $model->orderHasOne->customerHasOne->id], [
                                    'target' => '_blank',
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
                                ]);
                            }
                        ],
                        'co_so',
                        'time_start:datetime',
                        'time_end:datetime',
                        'note',
                        'created_at:datetime',
                        'updated_at:datetime',
                        [
                            'attribute' => 'userCreated.userProfile.fullname',
                            'label' => CustomerModule::t('customer>', 'Created By')
                        ],
                        [
                            'attribute' => 'userUpdated.userProfile.fullname',
                            'label' => CustomerModule::t('customer>', 'Updated By')
                        ],
                    ],
                ]) ?>
            </section>
        </div>
    </div>
</div>
