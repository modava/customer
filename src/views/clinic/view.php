<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\widgets\ToastrWidget;
use modava\customer\widgets\NavbarWidgets;
use modava\customer\CustomerModule;
use modava\customer\models\table\CustomerTable;
use modava\customer\models\table\CustomerStatusCallTable;
use modava\customer\models\table\CustomerStatusDatHenTable;
use modava\customer\models\table\CustomerStatusDongYTable;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\SalesOnline */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => CustomerModule::t('customer', 'Customers'), 'url' => ['index']];
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
            <?php if ($model->statusDongYHasOne != null && $model->statusDongYHasOne->accept == CustomerStatusDongYTable::STATUS_PUBLISHED) { ?>
                <?= Html::a('<i class="fa fa-plus"></i> ' . CustomerModule::t('customer', 'Order'), ['/customer/customer-order/create', 'customer_id' => $model->primaryKey], [
                    'class' => 'btn btn-success'
                ]) ?>
            <?php } ?>
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
                        'avatar',
                        'name',
                        'code',
                        'birthday:date',
                        [
                            'attribute' => 'sex',
                            'value' => function ($model) {
                                if ($model->sex === null || !array_key_exists($model->sex, CustomerTable::SEX)) return null;
                                return CustomerTable::SEX[$model->sex];
                            }
                        ],
                        'phone',
                        [
                            'attribute' => 'address',
                            'label' => CustomerModule::t('customer', 'Address'),
                            'value' => function ($model) {
                                return $model->address . ', ' . $model->wardHasOne->name . ', ' . $model->wardHasOne->districtHasOne->name . ', ' . $model->wardHasOne->districtHasOne->provinceHasOne->name . ', ' . $model->wardHasOne->districtHasOne->provinceHasOne->countryHasOne->CommonName;
                            }
                        ],
                        [
                            'attribute' => 'permission_user',
                            'value' => function ($model) {
                                if ($model->permissionUserHasOne == null || $model->permissionUserHasOne->userProfile == null) return null;
                                return $model->permissionUserHasOne->userProfile->fullname;
                            }
                        ],
                        [
                            'attribute' => 'type',
                            'value' => function ($model) {
                                if ($model->type == null || !array_key_exists($model->type, CustomerTable::TYPE)) return null;
                                return CustomerTable::TYPE[$model->type];
                            }
                        ],
                        [
                            'attribute' => 'status_dat_hen',
                            'value' => function ($model) {
                                if ($model->statusDatHenHasOne == null) return null;
                                $status = $model->statusDatHenHasOne->name;
                                if ($model->statusCallHasOne != null) $status = $model->statusCallHasOne->name . ' - ' . $status;
                                return $status;
                            }
                        ],
                        [
                            'attribute' => 'time_lich_hen',
                            'visible' => $model->type == CustomerTable::TYPE_ONLINE && $model->statusCallHasOne != null && $model->statusCallHasOne->accept == CustomerStatusCallTable::STATUS_PUBLISHED,
                            'value' => function ($model) {
                                if ($model->time_lich_hen == null) return null;
                                return date('d-m-Y H:i', $model->time_lich_hen);
                            }
                        ],
                        [
                            'attribute' => 'time_come',
                            'visible' => $model->statusDatHenHasOne != null && $model->statusDatHenHasOne->accept == CustomerStatusDatHenTable::STATUS_PUBLISHED,
                            'value' => function ($model) {
                                if ($model->time_come == null) return null;
                                return date('d-m-Y H:i', $model->time_come);
                            }
                        ],
                        [
                            'attribute' => 'status_dong_y',
                            'visible' => $model->statusDatHenHasOne != null && $model->statusDatHenHasOne->accept == CustomerStatusDatHenTable::STATUS_PUBLISHED,
                            'value' => function ($model) {
                                if ($model->statusDongYHasOne == null) return null;
                                return $model->statusDongYHasOne->name;
                            }
                        ],
                        [
                            'attribute' => 'co_so',
                            'visible' => $model->statusCallHasOne != null && $model->statusCallHasOne->accept == CustomerStatusCallTable::STATUS_PUBLISHED,
                            'value' => function ($model) {
                                if ($model->coSoHasOne == null) return null;
                                return $model->coSoHasOne->name;
                            }
                        ],
                        [
                            'attribute' => 'sale_online_note',
                            'visible' => $model->type == CustomerTable::TYPE_ONLINE,
                            'value' => function ($model) {
                                return $model->sale_online_note;
                            }
                        ],
                        'direct_sale_note',
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
