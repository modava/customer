<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Select2;
use yii\widgets\ActiveForm;
use backend\widgets\ToastrWidget;
use modava\customer\CustomerModule;
use yii\helpers\ArrayHelper;
use modava\customer\models\table\CustomerTable;
use dosamigos\datepicker\DatePicker;
use modava\location\models\table\LocationCountryTable;
use modava\location\models\table\LocationProvinceTable;
use modava\location\models\table\LocationDistrictTable;
use modava\location\models\table\LocationWardTable;
use modava\customer\models\table\CustomerStatusDatHenTable;
use modava\customer\models\table\CustomerStatusDongYTable;
use modava\customer\components\CustomerDateTimePicker;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\SalesOnline */
/* @var $form yii\widgets\ActiveForm */

if ($model->wardHasOne != null) {
    $model->district = $model->wardHasOne->districtHasOne->id;
    $model->province = $model->wardHasOne->districtHasOne->provinceHasOne->id;
    $model->country = $model->wardHasOne->districtHasOne->provinceHasOne->countryHasOne->id;
}
if ($model->birthday != null) {
    $model->birthday = date('d-m-Y', strtotime($model->birthday));
}
if ($model->time_come != null) {
    $model->time_come = date('d-m-Y H:i', $model->time_come);
}

$status_dat_hen_den = ArrayHelper::map(CustomerStatusDatHenTable::getDatHenDen(), 'id', 'id');
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

        <?php if ($model->primaryKey != null) { ?>
            <div class="row">
                <div class="col-md-6 col-12">
                    <?= $form->field($model, 'status_dat_hen')->dropDownList(ArrayHelper::map(CustomerStatusDatHenTable::getAllDatHen(), 'id', 'name'), [
                        'id' => 'status-dat-hen',
                        'prompt' => 'Trạng thái đặt hẹn...'
                    ]) ?>
                </div>
            </div>
        <?php } ?>
        <div class="status-dat-hen-den"
             style="display: <?= $model->primaryKey == null || in_array($model->status_dat_hen, $status_dat_hen_den) ? 'block' : 'none' ?>;">
            <div class="row">
                <div class="col-md-6 col-12">
                    <?= $form->field($model, 'time_come')->widget(CustomerDateTimePicker::class, [
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
                        'prompt' => 'Trạng thái đồng ý...'
                    ]) ?>
                </div>
            </div>
        </div>

        <?= $form->field($model, 'direct_sale_note')->textarea(['maxlength' => true, 'rows' => 5]) ?>

        <div class="form-group">
            <?= Html::submitButton(CustomerModule::t('customer', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
<?php
$json_status_dat_hen_den = json_encode(array_values($status_dat_hen_den));
$script = <<< JS
var status_dat_hen_den = $json_status_dat_hen_den;
$(function(){
    $('#status-dat-hen').on('change', function(){
        var status = parseInt($(this).val()) || null;
        if(status_dat_hen_den.includes(status)){
            $('.status-dat-hen-den').slideDown();
        } else {
            $('.status-dat-hen-den').hide().find('.has-error').removeClass('has-error').find('.help-block').html('');
        }
    });
});
JS;
$this->registerJs($script, \yii\web\View::POS_END);