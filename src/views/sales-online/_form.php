<?php

use cheatsheet\Time;
use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Select2;
use yii\widgets\ActiveForm;
use backend\widgets\ToastrWidget;
use modava\customer\CustomerModule;
use yii\helpers\ArrayHelper;
use modava\customer\models\table\CustomerTable;
use modava\customer\models\table\CustomerStatusFailTable;
use modava\customer\models\table\CustomerStatusCallTable;
use dosamigos\datepicker\DatePicker;
use modava\customer\components\CustomerDateTimePicker;
use modava\location\models\table\LocationCountryTable;
use modava\location\models\table\LocationProvinceTable;
use modava\location\models\table\LocationDistrictTable;
use modava\location\models\table\LocationWardTable;
use modava\customer\models\table\CustomerAgencyTable;
use modava\customer\models\table\CustomerOriginTable;
use modava\customer\models\table\CustomerFanpageTable;
use modava\settings\models\table\SettingCoSoTable;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\SalesOnline */
/* @var $form yii\widgets\ActiveForm */

if ($model->wardHasOne != null) {
    $model->district = $model->wardHasOne->districtHasOne->id;
    $model->province = $model->wardHasOne->districtHasOne->provinceHasOne->id;
    $model->country = $model->wardHasOne->districtHasOne->provinceHasOne->countryHasOne->id;
}
if ($model->fanpageHasOne != null) {
    $model->origin = $model->fanpageHasOne->originHasOne->id;
    $model->agency = $model->fanpageHasOne->originHasOne->agencyHasMany[0]->id;
}
if ($model->birthday != null) {
    $model->birthday = date('d-m-Y', strtotime($model->birthday));
}
if ($model->time_lich_hen != null) {
    $model->time_lich_hen = date('d-m-Y H:i', $model->time_lich_hen);
}
if ($model->status_fail == null) {
    $model->remind_call = true;
}
if ($model->remind_call_time == null || $model->remind_call_time < time()) {
    $model->remind_call_time = date('d-m-Y H:i', strtotime(date('d-m-Y') . ' +1day') + 8 * Time::SECONDS_IN_AN_HOUR);
} else {
    $model->remind_call_time = date('d-m-Y H:i', $model->remind_call_time);
}

$status_call_accept = ArrayHelper::map(CustomerStatusCallTable::getStatusCallDatHen(), 'id', 'id');
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
    <div class="customer-form">
        <?php $form = ActiveForm::begin([
            'id' => 'form-sales-online',
            'enableAjaxValidation' => true,
            'validationUrl' => Url::toRoute(['validate-sales-online', 'id' => $model->primaryKey]),
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
                    'prompt' => CustomerModule::t('customer', 'Sex')
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'country')->dropDownList(ArrayHelper::map(LocationCountryTable::getAllCountry(Yii::$app->language), 'id', 'CommonName'), [
                    'prompt' => CustomerModule::t('customer', 'Country'),
                    'class' => 'form-control load-data-on-change',
                    'load-data-element' => '#select-province',
                    'load-data-url' => Url::toRoute(['/location/location-province/get-province-by-country']),
                    'load-data-key' => 'country',
                    'load-data-method' => 'GET',
                    'load-data-callback' => '$("#select-district, #select-ward").find("option[value!=\'\']").remove();'
                ]) ?>
            </div>
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'province')->dropDownList(ArrayHelper::map(LocationProvinceTable::getProvinceByCountry($model->country, Yii::$app->language), 'id', 'name'), [
                    'id' => 'select-province',
                    'prompt' => CustomerModule::t('customer', 'Province'),
                    'class' => 'form-control load-data-on-change',
                    'load-data-element' => '#select-district',
                    'load-data-url' => Url::toRoute(['/location/location-district/get-district-by-province']),
                    'load-data-key' => 'province',
                    'load-data-method' => 'GET',
                    'load-data-callback' => '$("#select-ward").find("option[value!=\'\']").remove();'
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'district')->dropDownList(ArrayHelper::map(LocationDistrictTable::getDistrictByProvince($model->province, Yii::$app->language), 'id', 'name'), [
                    'id' => 'select-district',
                    'prompt' => CustomerModule::t('customer', 'District'),
                    'class' => 'form-control load-data-on-change',
                    'load-data-element' => '#select-ward',
                    'load-data-url' => Url::toRoute(['/location/location-ward/get-ward-by-district']),
                    'load-data-key' => 'district',
                    'load-data-method' => 'GET',
                ]) ?>
            </div>
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'ward')->dropDownList(ArrayHelper::map(LocationWardTable::getWardByDistrict($model->district), 'id', 'name'), [
                    'prompt' => CustomerModule::t('customer', 'Ward'),
                    'id' => 'select-ward',
                ]) ?>
            </div>
        </div>
        <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        <hr>
        <h5 class="form-group">Thông tin hệ thống</h5>
        <div class="row">
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'agency')->dropDownList(ArrayHelper::map(CustomerAgencyTable::getAllAgency(), 'id', 'name'), [
                    'prompt' => CustomerModule::t('customer', 'Agency'),
                    'class' => 'form-control load-data-on-change',
                    'load-data-url' => Url::toRoute(['/customer/customer-origin/get-origin-by-agency']),
                    'load-data-element' => '#select-origin',
                    'load-data-key' => 'agency',
                    'load-data-method' => 'GET',
                    'load-data-callback' => '$("#select-fanpage").find("option[value!=\'\']").remove();'
                ]) ?>
            </div>
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'origin')->dropDownList(ArrayHelper::map(CustomerOriginTable::getOriginByAgency($model->agency), 'id', 'name'), [
                    'prompt' => CustomerModule::t('customer', 'Origin'),
                    'id' => 'select-origin',
                    'class' => 'form-control load-data-on-change',
                    'load-data-url' => Url::toRoute(['/customer/customer-fanpage/get-fanpage-by-origin']),
                    'load-data-element' => '#select-fanpage',
                    'load-data-key' => 'origin',
                    'load-data-method' => 'GET'
                ]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'fanpage_id')->dropDownList(ArrayHelper::map(CustomerFanpageTable::getFanpageByOrigin($model->origin), 'id', 'name'), [
                    'prompt' => CustomerModule::t('customer', 'Fanpage'),
                    'id' => 'select-fanpage'
                ]) ?>
            </div>
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'status_call')->dropDownList(ArrayHelper::map(CustomerStatusCallTable::getAllStatusCall(), 'id', 'name'), [
                    'id' => 'status_call',
                    'prompt' => 'Trạng thái gọi...'
                ]) ?>
            </div>
        </div>
        <div class="customer-status-call-fail"
             style="display: <?= $model->status_call != null && !in_array($model->status_call, $status_call_accept) ? 'block' : 'none' ?>;">
            <div class="row">
                <div class="col-md-6 col-12">
                    <?= $form->field($model, 'remind_call')->checkbox([
                        'id' => 'remind-call'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-12 remind-call-time"
                     style="display: <?= $model->remind_call == true ? 'block' : 'none' ?>">
                    <?= $form->field($model, 'remind_call_time')->widget(CustomerDateTimePicker::class, [
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
                    <?= $form->field($model, 'status_fail')->dropDownList(ArrayHelper::map(CustomerStatusFailTable::getAllStatusFail(), 'id', 'name'), [
                        'prompt' => 'Lý do fail...'
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="customer-status-call-success"
             style="display: <?= $model->status_call != null && in_array($model->status_call, $status_call_accept) ? 'block' : 'none' ?>;">
            <div class="row">
                <div class="col-md-6 col-12">
                    <?= $form->field($model, 'time_lich_hen')->widget(CustomerDateTimePicker::class, [
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
                <div class="col-md-6 col-12">
                    <?= $form->field($model, 'co_so')->dropDownList(ArrayHelper::map(SettingCoSoTable::getAllCoSo(), 'id', 'name'), [
                        'prompt' => 'Cơ sở...'
                    ]) ?>
                </div>
            </div>
        </div>

        <?= $form->field($model, 'sale_online_note')->textarea(['maxlength' => true, 'rows' => 5]) ?>

        <div class="form-group">
            <?= Html::submitButton(CustomerModule::t('customer', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
<?php
$json_status_call_accept = json_encode(array_values($status_call_accept));
$script = <<< JS
var status_call_accept = $json_status_call_accept;
/*var form = $('#form-sales-online');
form.on('submit', function(e){
    e.preventDefault();
    return false;
});*/
$(function(){
    // $('#select-country').trigger('change');
    $('#status_call').on('change', function(){
        var status = parseInt($(this).val()) || null;
        if(status == null){
            $('.customer-status-call-success, .customer-status-call-fail').hide().find('.has-error').removeClass('has-error').find('.help-block').html('');
        } else if(status_call_accept.includes(status)){
            $('.customer-status-call-success').slideDown();
            $('.customer-status-call-fail').hide().find('.has-error').removeClass('has-error').find('.help-block').html('');
        } else {
            $('.customer-status-call-fail').slideDown();
            $('.customer-status-call-success').hide().find('.has-error').removeClass('has-error').find('.help-block').html('');
        }
    });
    $('#remind-call').on('change', function(){
        if($(this).is(':checked')){
            $('.remind-call-time').slideDown();
        } else {
            $('.remind-call-time').hide();
        }
    });
});
JS;
$this->registerJs($script, \yii\web\View::POS_END);