<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\widgets\ToastrWidget;
use modava\customer\widgets\NavbarWidgets;
use modava\customer\CustomerModule;
use modava\customer\models\table\CustomerTable;
use modava\customer\models\table\CustomerStatusCallTable;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\Customer */

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
                        'code',
                        'name',
                        'birthday',
                        [
                            'attribute' => 'sex',
                            'value' => function ($model) {
                                if (!array_key_exists($model->sex, Yii::$app->getModule('customer')->params['sex'])) return null;
                                return Yii::$app->getModule('customer')->params['sex'][$model->sex];
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
                        'avatar',
                        [
                            'attribute' => 'fanpageHasOne.name',
                            'label' => CustomerModule::t('customer', 'Fanpage')
                        ],
                        [
                            'attribute' => 'permissionUserHasOne.userProfile.fullname',
                            'label' => CustomerModule::t('customer', 'Permission User')
                        ],
                        [
                            'attribute' => 'permissionUserHasOne.userProfile.fullname',
                            'label' => CustomerModule::t('customer', 'Customer Type'),
                            'value' => function ($model) {
                                if (!array_key_exists($model->type, CustomerTable::TYPE)) return null;
                                return CustomerTable::TYPE[$model->type];
                            }
                        ],
                        [
                            'attribute' => 'statusCallHasOne.name',
                            'label' => CustomerModule::t('customer', 'Status Call')
                        ],
                        [
                            'attribute' => 'statusFailHasOne.name',
                            'label' => CustomerModule::t('customer', 'Status Fail'),
                            'visible' => $model->statusCallHasOne->accept === CustomerStatusCallTable::STATUS_DISABLED,
                        ],
                        [
                            'attribute' => 'statusDatHenHasOne.name',
                            'label' => CustomerModule::t('customer', 'Status Dat Hen'),
                            'visible' => $model->statusCallHasOne->accept === CustomerStatusCallTable::STATUS_PUBLISHED,
                        ],
                        [
                            'attribute' => 'statusDongYHasOne.name',
                            'label' => CustomerModule::t('customer', 'Status Dong Y'),
                            'visible' => $model->statusCallHasOne->accept === CustomerStatusCallTable::STATUS_PUBLISHED,
                        ],
                        'time_lich_hen:datetime',
                        'time_come:datetime',
                        [
                            'attribute' => 'directSaleHasOne.userProfile.fullname',
                            'label' => CustomerModule::t('customer', 'Direct Sale')
                        ],
                        [
                            'attribute' => 'coSoHasOne.name',
                            'label' => CustomerModule::t('customer', 'Co So')
                        ],
                        'sale_online_note',
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
