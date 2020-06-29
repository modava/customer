<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\widgets\ToastrWidget;
use modava\customer\widgets\NavbarWidgets;
use modava\customer\CustomerModule;
use modava\customer\models\table\CustomerOrderTable;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\CustomerOrder */

$this->title = CustomerModule::t('customer', 'Order') . ': ' . $model->customerHasOne->name . ' (' . $model->code . ')';
$this->params['breadcrumbs'][] = ['label' => CustomerModule::t('customer', 'Đơn hàng'), 'url' => ['index']];
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
            <?php if ($model->status == CustomerOrderTable::STATUS_DISABLED) { ?>
                <?= Html::a('<i class="glyphicon glyphicon-list-alt"></i> ' . CustomerModule::t('customer', 'Treatment Schedule'), ['/customer/customer-treatment-schedule/create', 'order_id' => $model->primaryKey], ['class' => 'btn btn-warning']) ?>
                <?= Html::a('<i class="glyphicon glyphicon-credit-card"></i> ' . CustomerModule::t('customer', 'Payment'), ['/customer/customer-payment/index', 'order_id' => $model->primaryKey], ['class' => 'btn btn-success']) ?>
            <?php } ?>
            <a class="btn btn-outline-light" href="<?= Url::to(['create']); ?>"
               title="<?= CustomerModule::t('customer', 'Create'); ?>">
                <i class="fa fa-plus"></i> <?= CustomerModule::t('customer>', 'Create'); ?></a>
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
                        'customerHasOne.name',
                        'code',
                        'total',
                        'discount',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return Yii::$app->getModule('customer')->params['statusOrder'][$model->status];
                            }
                        ],
                        'co_so',
                        'ordered_at:datetime',
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
