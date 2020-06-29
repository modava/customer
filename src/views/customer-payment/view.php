<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\widgets\ToastrWidget;
use modava\customer\widgets\NavbarWidgets;
use modava\customer\CustomerModule;
use modava\customer\models\table\CustomerPaymentTable;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\CustomerPayment */

$this->title = CustomerModule::t('customer', 'Payment') . ': ' . $model->orderHasOne->customerHasOne->name . ' (' . $model->orderHasOne->code . ')';
$this->params['breadcrumbs'][] = ['label' => CustomerModule::t('customer', 'Customer Payments'), 'url' => ['index']];
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
                <i class="fa fa-plus"></i> <?= CustomerModule::t('customer', 'Create'); ?></a>
            <?= Html::a(CustomerModule::t('customer', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(CustomerModule::t('customer', 'Delete'), ['delete', 'id' => $model->id], [
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
                            'label' => CustomerModule::t('customer', 'Customers')
                        ],
                        [
                            'attribute' => 'orderHasOne.code',
                            'label' => CustomerModule::t('customer', 'Order')
                        ],
                        'price',
                        [
                            'attribute' => 'payments',
                            'value' => function ($model) {
                                if (array_key_exists($model->payments, CustomerPaymentTable::PAYMENTS)) return CustomerPaymentTable::PAYMENTS[$model->payments];
                                return CustomerPaymentTable::PAYMENTS[CustomerPaymentTable::PAYMENTS_THANH_TOAN];
                            }
                        ],
                        [
                            'attribute' => 'type',
                            'value' => function ($model) {
                                if (array_key_exists($model->type, CustomerPaymentTable::TYPE)) return CustomerPaymentTable::TYPE[$model->type];
                                return CustomerPaymentTable::TYPE[CustomerPaymentTable::TYPE_TIEN_MAT];
                            }
                        ],
                        'co_so',
                        'payment_at',
                        'created_at:datetime',
                        'updated_at:datetime',
                        [
                            'attribute' => 'userCreated.userProfile.fullname',
                            'label' => CustomerModule::t('customer', 'Created By')
                        ],
                        [
                            'attribute' => 'userUpdated.userProfile.fullname',
                            'label' => CustomerModule::t('customer', 'Updated By')
                        ],
                    ],
                ]) ?>
            </section>
        </div>
    </div>
</div>
