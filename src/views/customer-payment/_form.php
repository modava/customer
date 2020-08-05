<?php

use yii\helpers\Html;
use yii\helpers\Url;
use modava\select2\Select2;
use yii\widgets\ActiveForm;
use backend\widgets\ToastrWidget;
use modava\customer\CustomerModule;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use modava\customer\models\table\CustomerTable;
use modava\customer\models\table\CustomerOrderTable;
use modava\customer\models\table\CustomerPaymentTable;
use modava\customer\models\table\CustomerCoSoTable;
use modava\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\CustomerPayment */
/* @var $form yii\widgets\ActiveForm */

$model->payment_at = ($model->payment_at != null && is_numeric($model->payment_at)) ? date('d-m-Y H:i', $model->payment_at) : date('d-m-Y H:i');
$customerDongY = CustomerTable::getCustomerDongY();
$optionsCustomerDongY = [];
foreach ($customerDongY as $customer_dong_y) {
    $optionsCustomerDongY[$customer_dong_y->primaryKey] = [
        'data-co-so' => $customer_dong_y->co_so
    ];
}
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
    <div class="customer-payment-form">
        <?php $form = ActiveForm::begin(); ?>
        <?php if ($model->order_id == null && Yii::$app->controller->action->id == 'create') { ?>
            <div class="row">
                <div class="col-md-6 col-12">
                    <?= Select2::widget([
                        'model' => $model,
                        'attribute' => 'customer_id',
                        'data' => ArrayHelper::map($customerDongY, 'id', 'name'),
                        'options' => [
                            'id' => 'select-customer',
                            'class' => 'form-control load-data-on-change',
                            'load-data-element' => '#select-order',
                            'load-data-url' => Url::toRoute(['/customer/customer-order/get-order-by-customer']),
                            'load-data-key' => 'customer_id',
                            'load-data-callback' => '$("#select-order").trigger("change");',
                            'load-data-method' => 'GET',
                            'options' => $optionsCustomerDongY
                        ]
                    ]) ?>
                </div>
                <div class="col-md-6 col-12">
                    <?= Select2::widget([
                        'model' => $model,
                        'attribute' => 'order_id',
                        'data' => ArrayHelper::map(CustomerOrderTable::getOrderUnFinishByCustomer($model->customer_id), 'id', 'code'),
                        'options' => [
                            'id' => 'select-order'
                        ]
                    ]) ?>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'payment_at')->widget(DateTimePicker::class, [
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
                <?php
                if ($model->co_so == null) {
                    if (isset(Yii::$app->user->identity->co_so)) $model->co_so = Yii::$app->user->identity->co_so;
                    if ($model->orderHasOne != null) $model->co_so = $model->orderHasOne->customerHasOne->co_so;
                    else $model->co_so = null;
                }
                ?>
                <?= $form->field($model, 'co_so')->dropDownList(ArrayHelper::map(CustomerCoSoTable::getAllCoSo(), 'id', 'name'), []) ?>
            </div>
        </div>

        <div id="order-info"></div>
        <div id="payment-info">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12"></div>
                <div class="col-md-3 col-sm-6 col-12 text-right">
                    Tổng cộng:
                </div>
                <div class="col-md-3 col-sm-6 col-12 text-right">
                    <strong id="payment-tong-cong"></strong>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12"></div>
                <div class="col-md-3 col-sm-6 col-12 text-right">
                    Chiết khấu:
                </div>
                <div class="col-md-3 col-sm-6 col-12 text-right">
                    <strong id="payment-chiet-khau"></strong>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12"></div>
                <div class="col-md-3 col-sm-6 col-12 text-right">
                    Tạm tính:
                </div>
                <div class="col-md-3 col-sm-6 col-12 text-right">
                    <strong id="payment-tam-tinh"></strong>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12"></div>
                <div class="col-md-3 col-sm-6 col-12 text-right">
                    Đặt cọc:
                </div>
                <div class="col-md-3 col-sm-6 col-12 text-right">
                    <strong id="payment-dat-coc"></strong>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12"></div>
                <div class="col-md-3 col-sm-6 col-12 text-right">
                    Đã thanh toán:
                </div>
                <div class="col-md-3 col-sm-6 col-12 text-right">
                    <strong id="payment-thanh-toan"></strong>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-6 col-12"></div>
                <div class="col-md-3 col-sm-6 col-12 text-right">
                    Còn lại:
                </div>
                <div class="col-md-3 col-sm-6 col-12 text-right">
                    <strong id="payment-con-lai"></strong>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-12">
                <?= $form->field($model, 'price')->textInput([
                    'id' => 'payment-price',
                    'class' => 'form-control ipt-payment',
                    'type' => 'number',
                    'step' => '0.1'
                ]) ?>
            </div>
            <div class="col-md-4 col-12">
                <?= Select2::widget([
                    'model' => $model,
                    'attribute' => 'payments',
                    'data' => CustomerPaymentTable::PAYMENTS,
                    'options' => [
                        'id' => 'payment-payments',
                        'class' => 'form-control ipt-payment'
                    ]
                ]) ?>
            </div>
            <div class="col-md-4 col-12">
                <?= Select2::widget([
                    'model' => $model,
                    'attribute' => 'type',
                    'data' => CustomerPaymentTable::TYPE,
                    'options' => [
                        'class' => 'form-control ipt-payment'
                    ]
                ]) ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton(CustomerModule::t('customer', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
<?php
$url_get_payment_info = Url::toRoute(['get-payment-info']);
$order_id = $model->order_id;
$payment_id = $model->primaryKey;
$payments_thanh_toan = CustomerPaymentTable::PAYMENTS_THANH_TOAN;
$payments_dat_coc = CustomerPaymentTable::PAYMENTS_DAT_COC;
$text_payments_dat_coc = CustomerPaymentTable::PAYMENTS[$payments_dat_coc];
$script = <<< JS
function number(number, fix = 1){
    if(number % 1 === 0) return number;
    if(typeof fix !== 'number') fix = 1;
    return Number(parseFloat(number)).toFixed(fix);
}
function getOrdertInfo(order_id){
    $.get('$url_get_payment_info', {order_id: order_id, payment_id: '$payment_id'}, res => {
        $('#order-info').html(res.order_info);
        // $('#payment-price').val('');
        if(res.code === 200){
            $('#payment-tong-cong').attr('data', res.total).html(res.total);
            $('#payment-chiet-khau').attr('data', res.discount).html(res.discount);
            $('#payment-tam-tinh').attr('data', res.total - res.discount).html(res.total - res.discount);
            $('#payment-dat-coc').attr('data', res.data_deposit).html(res.deposit);
            $('#payment-thanh-toan').attr('data', res.data_payment).html(res.payment);
            $('#payment-con-lai').attr('data', res.total - (res.discount + res.deposit + res.payment)).html(res.total - (res.discount + res.deposit + res.payment));
            if(res.data_deposit > 0 && [null, undefined, ''].includes('$payment_id')) {
                $('#payment-payments').select2('destroy').find('option[value="$payments_dat_coc"]').remove().end().select2();
            } else if($('#payment-payments option[value="$payments_dat_coc"]').length <= 0) {
                $('#payment-payments').select2('destroy').append('<option value="$payments_dat_coc">$text_payments_dat_coc</option>');
                $('#payment-payments').select2();
            }
        }
    });
}
function handlePayment(){
    var price = parseFloat($('#payment-price').val()) || 0,
        payments = $('#payment-payments').val() || '$payments_thanh_toan',
        total = parseFloat($('#payment-tong-cong').attr('data')) || 0,
        deposit = parseFloat($('#payment-dat-coc').attr('data')) || 0,
        discount = parseFloat($('#payment-chiet-khau').attr('data')) || 0,
        payment = parseFloat($('#payment-thanh-toan').attr('data')) || 0,
        rest = parseFloat(total - (discount + deposit + payment));
    console.log(price);
    if(price > rest) {
        price = rest;
    }
    if(payments === '$payments_dat_coc'){
        deposit += price;
    } else {
        payment += price;
    }
    $('#payment-dat-coc').html(number(deposit));
    $('#payment-thanh-toan').html(number(payment));
    $('#payment-con-lai').html(number(rest - price));
    $('#payment-price').val(price);
}
if('$order_id' !== '') {
    getOrdertInfo($order_id)
};
var timeoutHandlePayment;
$('body').on('change', '.ipt-payment', function(){
    clearTimeout(timeoutHandlePayment);
    handlePayment();
}).on('keyup', '.ipt-payment', function(){
    clearTimeout(timeoutHandlePayment);
    timeoutHandlePayment = setTimeout(handlePayment, 300);
}).on('change', '#select-order', function(){
    var order_id = $(this).val();
    getOrdertInfo(order_id)
}).on('change', '#select-customer', function(){
    var co_so = $(this).find('option:selected').attr('data-co-so') || null;
    $('#customerpayment-co_so').find('option').prop('selected', false).removeAttr('selected');
    $('#customerpayment-co_so').find('option[value="'+ co_so +'"]').prop('selected', true).attr('selected', 'selected');
});
$(function(){
    $('#select-customer').trigger('change');
});
JS;
$this->registerJs($script, \yii\web\View::POS_END);