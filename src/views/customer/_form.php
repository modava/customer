<?php

use cheatsheet\Time;
use yii\helpers\ArrayHelper;
use modava\customer\models\table\CustomerStatusCallTable;
use modava\customer\models\Customer;
use modava\customer\models\table\CustomerTable;
use dosamigos\datepicker\DatePicker;
use modava\location\models\table\LocationCountryTable;
use modava\location\models\table\LocationProvinceTable;
use modava\location\models\table\LocationDistrictTable;
use modava\location\models\table\LocationWardTable;
use modava\customer\models\table\CustomerAgencyTable;
use modava\customer\models\table\CustomerOriginTable;
use modava\customer\models\table\CustomerFanpageTable;
use modava\customer\components\CustomerDateTimePicker;
use modava\customer\models\table\CustomerStatusFailTable;
use modava\customer\models\table\CustomerCoSoTable;
use modava\customer\models\table\CustomerStatusDatHenTable;
use modava\customer\models\table\CustomerStatusDongYTable;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\widgets\ToastrWidget;
use modava\customer\CustomerModule;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\Customer */
/* @var $form yii\widgets\ActiveForm */

if ($model->birthday != null) {
    $model->birthday = date('d-m-Y', strtotime($model->birthday));
}
if ($model->wardHasOne != null) {
    $model->district = $model->wardHasOne->districtHasOne->id;
    $model->province = $model->wardHasOne->districtHasOne->provinceHasOne->id;
    $model->country = $model->wardHasOne->districtHasOne->provinceHasOne->countryHasOne->id;
}
$status_call_accept = ArrayHelper::map(CustomerStatusCallTable::getStatusCallDatHen(), 'id', 'id');
$status_dat_hen_den = ArrayHelper::map(CustomerStatusDatHenTable::getDatHenDen(), 'id', 'id');
$status_dong_y = ArrayHelper::map(CustomerStatusDongYTable::getAllDongY(), 'id', 'id');
$status_dong_y_fail = ArrayHelper::map(CustomerStatusFailTable::getAllStatusDongYFail(), 'id', 'name');

$is_online = in_array($model->scenario, [Customer::SCENARIO_ONLINE, Customer::SCENARIO_ADMIN]);
$is_clinic = in_array($model->scenario, [Customer::SCENARIO_ADMIN, Customer::SCENARIO_CLINIC]);
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
    <div class="customer-form">
        <?php $form = ActiveForm::begin([
            'id' => 'form-sales-online',
            'enableAjaxValidation' => true,
            'validationUrl' => Url::toRoute(['validate', 'id' => $model->primaryKey]),
            'action' => Url::toRoute([Yii::$app->controller->action->id, 'id' => $model->primaryKey])
        ]); ?>
        <h5 class="form-group">Thông tin cá nhân</h5>
        <div class="row">
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'birthday')->widget(DatePicker::class, [
                    'addon' => '<button type="button" class="btn btn-increment btn-light"><i class="ion ion-md-calendar"></i></button>',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'dd-mm-yyyy',
                        'todayHighlight' => true,
                        'endDate' => '+0d'
                    ]
                ]) ?>
            </div>
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'sex')->dropDownList(CustomerTable::SEX, [
                    'prompt' => CustomerModule::t('customer', 'Chọn giới tính...')
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'country')->dropDownList(ArrayHelper::map(LocationCountryTable::getAllCountry(Yii::$app->language), 'id', 'CommonName'), [
                    'prompt' => CustomerModule::t('customer', 'Chọn quốc gia...'),
                    'class' => 'form-control load-data-on-change',
                    'load-data-element' => '#select-province',
                    'load-data-url' => Url::toRoute(['/location/location-province/get-province-by-country']),
                    'load-data-key' => 'country',
                    'load-data-data' => json_encode(['option_tag' => 'true']),
                    'load-data-method' => 'GET',
                    'load-data-callback' => '$("#select-district, #select-ward").find("option[value!=\'\']").remove();'
                ]) ?>
            </div>
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'province')->dropDownList(ArrayHelper::map(LocationProvinceTable::getProvinceByCountry($model->country, Yii::$app->language), 'id', 'name'), [
                    'id' => 'select-province',
                    'prompt' => CustomerModule::t('customer', 'Chọn Tỉnh/Thành phố...'),
                    'class' => 'form-control load-data-on-change',
                    'load-data-element' => '#select-district',
                    'load-data-url' => Url::toRoute(['/location/location-district/get-district-by-province']),
                    'load-data-key' => 'province',
                    'load-data-data' => json_encode(['option_tag' => 'true']),
                    'load-data-method' => 'GET',
                    'load-data-callback' => '$("#select-ward").find("option[value!=\'\']").remove();'
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'district')->dropDownList(ArrayHelper::map(LocationDistrictTable::getDistrictByProvince($model->province, Yii::$app->language), 'id', 'name'), [
                    'id' => 'select-district',
                    'prompt' => CustomerModule::t('customer', 'Chọn Quận/Huyện...'),
                    'class' => 'form-control load-data-on-change',
                    'load-data-element' => '#select-ward',
                    'load-data-url' => Url::toRoute(['/location/location-ward/get-ward-by-district']),
                    'load-data-key' => 'district',
                    'load-data-data' => json_encode(['option_tag' => 'true']),
                    'load-data-method' => 'GET',
                ]) ?>
            </div>
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'ward')->dropDownList(ArrayHelper::map(LocationWardTable::getWardByDistrict($model->district), 'id', 'name'), [
                    'prompt' => CustomerModule::t('customer', 'Chọn Phường/Xã...'),
                    'id' => 'select-ward',
                ]) ?>
            </div>
        </div>
        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        <?php if ($model->scenario === Customer::SCENARIO_ADMIN) { ?>
            <div class="row">
                <div class="col-md-6 col-12">
                    <?= $form->field($model, 'type')->dropDownList(CustomerTable::TYPE, []) ?>
                </div>
            </div>
        <?php } ?>
        <hr>
        <h5 class="form-group">Thông tin hệ thống</h5>
        <?php
        if ($model->fanpageHasOne != null) {
            $model->origin = $model->fanpageHasOne->originHasOne->id;
            $model->agency = $model->fanpageHasOne->originHasOne->agencyHasMany[0]->id;
        }
        ?>
        <div class="row">
            <?php if ($is_online) { ?>
                <div class="col-md-6 col-12">
                    <?= $form->field($model, 'agency')->dropDownList(ArrayHelper::map(CustomerAgencyTable::getAllAgency(), 'id', 'name'), [
                        'prompt' => CustomerModule::t('customer', 'Chọn agency...'),
                        'class' => 'form-control load-data-on-change',
                        'load-data-url' => Url::toRoute(['/customer/customer-origin/get-origin-by-agency']),
                        'load-data-element' => '#select-origin',
                        'load-data-key' => 'agency',
                        'load-data-method' => 'GET',
                        'load-data-callback' => '$("#select-fanpage").find("option[value!=\'\']").remove();'
                    ])->label(CustomerModule::t('customer', 'Agency')) ?>
                </div>
                <div class="col-md-6 col-12">
                    <?= $form->field($model, 'origin')->dropDownList(ArrayHelper::map(CustomerOriginTable::getOriginByAgency($model->agency), 'id', 'name'), [
                        'prompt' => CustomerModule::t('customer', 'Chọn nguồn trực tuyến...'),
                        'id' => 'select-origin',
                        'class' => 'form-control load-data-on-change',
                        'load-data-url' => Url::toRoute(['/customer/customer-fanpage/get-fanpage-by-origin']),
                        'load-data-element' => '#select-fanpage',
                        'load-data-key' => 'origin',
                        'load-data-method' => 'GET'
                    ])->label(CustomerModule::t('customer', 'Nguồn trực tuyến')) ?>
                </div>
                <div class="col-md-6 col-12">
                    <?= $form->field($model, 'fanpage_id')->dropDownList(ArrayHelper::map(CustomerFanpageTable::getFanpageByOrigin($model->origin), 'id', 'name'), [
                        'prompt' => CustomerModule::t('customer', 'Chọn fanpage facebook...'),
                        'id' => 'select-fanpage'
                    ]) ?>
                </div>
                <div class="col-md-6 col-12">
                    <?= $form->field($model, 'status_call')->dropDownList(ArrayHelper::map(CustomerStatusCallTable::getAllStatusCall(), 'id', 'name'), [
                        'id' => 'status_call',
                        'prompt' => CustomerModule::t('customer', 'Trạng thái gọi...')
                    ]) ?>
                </div>
                <div class="col-12 customer-status-call-fail"
                     style="display: <?= $model->status_call != null && !in_array($model->status_call, $status_call_accept) ? 'block' : 'none' ?>;">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <?php
                            if ($model->status_fail == null) {
                                $model->remind_call = true;
                            }
                            echo $form->field($model, 'remind_call')->checkbox([
                                'id' => 'remind-call'
                            ]) ?>
                        </div>
                        <div class="col-md-6 col-12"></div>
                        <div class="col-md-6 col-12 remind-call-time"
                             style="display: <?= $model->remind_call == true ? 'block' : 'none' ?>">
                            <?php
                            if ($model->remind_call_time == null || $model->remind_call_time < time()) {
                                $model->remind_call_time = date('d-m-Y H:i', strtotime(date('d-m-Y') . ' +1day') + 8 * Time::SECONDS_IN_AN_HOUR);
                            } else {
                                $model->remind_call_time = date('d-m-Y H:i', $model->remind_call_time);
                            }
                            echo $form->field($model, 'remind_call_time')->widget(CustomerDateTimePicker::class, [
                                'template' => '{input}{button}',
                                'pickButtonIcon' => 'btn btn-increment btn-light',
                                'pickIconContent' => Html::tag('span', '', ['class' => 'glyphicon glyphicon-th']),
                                'clientOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy hh:ii',
                                    'todayHighLight' => true,
                                    'startDate' => '-0d'
                                ]
                            ]) ?>
                        </div>
                        <div class="col-md-6 col-12">
                            <?= $form->field($model, 'status_fail')->dropDownList(ArrayHelper::map(CustomerStatusFailTable::getAllStatusCallFail(), 'id', 'name'), [
                                'prompt' => CustomerModule::t('customer', 'Lý do fail...')
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-12 customer-status-call-success"
                     style="display: <?= $model->status_call != null && in_array($model->status_call, $status_call_accept) ? 'block' : 'none' ?>;">
                    <?php
                    if ($model->time_lich_hen != null) {
                        $model->time_lich_hen = is_numeric($model->time_lich_hen) ? date('d-m-Y H:i', $model->time_lich_hen) : $model->time_lich_hen;
                    }
                    echo $form->field($model, 'time_lich_hen')->widget(CustomerDateTimePicker::class, [
                        'template' => '{input}{button}',
                        'pickButtonIcon' => 'btn btn-increment btn-light',
                        'pickIconContent' => Html::tag('span', '', ['class' => 'glyphicon glyphicon-th']),
                        'clientOptions' => [
                            'autoclose' => true,
                            'format' => 'dd-mm-yyyy hh:ii',
                            'todayHighLight' => true,
                        ]
                    ]) ?>
                </div>
            <?php } ?>
            <div class="col-md-6 col-12 customer-status-call-success"
                 style="display: <?= $model->status_call != null && in_array($model->status_call, $status_call_accept) ? 'block' : 'none' ?>;">
                <?= $form->field($model, 'co_so')->dropDownList(ArrayHelper::map(CustomerCoSoTable::getAllCoSo(), 'id', 'name'), [
                    'prompt' => CustomerModule::t('customer', 'Chọn cơ sở...')
                ]) ?>
            </div>
            <?php if ($is_clinic) { ?>
                <div class="col-12 clinic-content"
                     style="display: <?= ($model->primaryKey == null && $model->scenario !== Customer::SCENARIO_ADMIN) || in_array($model->status_call, $status_call_accept) ? 'block' : 'none' ?>;">
                    <div class="row">
                        <?php if ($model->primaryKey != null || $model->scenario === Customer::SCENARIO_ADMIN) { ?>
                            <div class="col-md-6 col-12">
                                <?= $form->field($model, 'status_dat_hen')->dropDownList(ArrayHelper::map(CustomerStatusDatHenTable::getAllDatHen(), 'id', 'name'), [
                                    'id' => 'status-dat-hen',
                                    'prompt' => 'Trạng thái đặt hẹn...'
                                ]) ?>
                            </div>
                        <?php } ?>
                        <div class="col-12 status-dat-hen-den"
                             style="display: <?= ($model->primaryKey == null && $model->scenario !== Customer::SCENARIO_ADMIN) || in_array($model->status_dat_hen, $status_dat_hen_den) ? 'block' : 'none' ?>;">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <?php
                                    if ($model->time_come != null) {
                                        $model->time_come = date('d-m-Y H:i', $model->time_come);
                                    }
                                    echo $form->field($model, 'time_come')->widget(CustomerDateTimePicker::class, [
                                        'template' => '{input}{button}',
                                        'pickButtonIcon' => 'btn btn-increment btn-light',
                                        'pickIconContent' => Html::tag('span', '', ['class' => 'glyphicon glyphicon-th']),
                                        'clientOptions' => [
                                            'autoclose' => true,
                                            'format' => 'dd-mm-yyyy hh:ii',
                                            'todayHighLight' => true,
                                            'startDate' => '+0d'
                                        ]
                                    ]) ?>
                                </div>
                                <div class="col-md-6 col-12">
                                    <?= $form->field($model, 'status_dong_y')->dropDownList(ArrayHelper::map(CustomerStatusDongYTable::getAll(), 'id', 'name'), [
                                        'prompt' => 'Trạng thái đồng ý...',
                                        'id' => 'status_dong_y'
                                    ]) ?>
                                </div>
                                <div class="col-md-6 col-12 status-dong-y-fail"
                                     style="display: <?= $model->status_dong_y == null || in_array($model->status_dong_y, $status_dong_y) ? 'none' : 'block' ?>">
                                    <?= $form->field($model, 'status_dong_y_fail')->dropDownList($status_dong_y_fail, [
                                        'prompt' => 'Lý do chốt fail...'
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if ($is_online) { ?>
                <div class="col-12">
                    <?= $form->field($model, 'sale_online_note')->textarea(['maxlength' => true, 'rows' => 5]) ?>
                </div>
            <?php } ?>
            <?php if ($is_clinic) { ?>
                <div class="col-12 clinic-content"
                     style="display: <?= ($model->primaryKey == null && $model->scenario !== Customer::SCENARIO_ADMIN) || in_array($model->status_call, $status_call_accept) ? 'block' : 'none' ?>;">
                    <?= $form->field($model, 'direct_sale_note')->textarea(['maxlength' => true, 'rows' => 5]) ?>
                </div>
            <?php } ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton(CustomerModule::t('customer', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
<?php
$json_status_call_accept = json_encode(array_values($status_call_accept));
$json_status_dat_hen_den = json_encode(array_values($status_dat_hen_den));
$json_status_dong_y = json_encode(array_values($status_dong_y));
$script = <<< JS
var status_call_accept = $json_status_call_accept;
var status_dat_hen_den = $json_status_dat_hen_den;
var status_dong_y = $json_status_dong_y;
JS;
$this->registerJs($script, \yii\web\View::POS_HEAD);

if (in_array($model->scenario, [Customer::SCENARIO_ADMIN, Customer::SCENARIO_ONLINE])) {
    \modava\customer\assets\CustomerOnlineAsset::register($this);
}
if (in_array($model->scenario, [Customer::SCENARIO_ADMIN, Customer::SCENARIO_CLINIC])) {
    \modava\customer\assets\CustomerClinicAsset::register($this);
}
if ($model->scenario === Customer::SCENARIO_ADMIN) {
    \modava\customer\assets\CustomerAdminAsset::register($this);
}