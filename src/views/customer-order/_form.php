<?php

use modava\select2\assets\Select2Asset;
use yii\helpers\Html;
use yii\helpers\Url;
use modava\customer\models\table\CustomerProductTable;
use modava\product\models\table\ProductCategoryTable;
use modava\customer\models\CustomerPayment;
use yii\widgets\ActiveForm;
use backend\widgets\ToastrWidget;
use modava\customer\CustomerModule;
use modava\select2\Select2;
use yii\helpers\ArrayHelper;
use unclead\multipleinput\MultipleInput;
use modava\customer\models\table\CustomerTable;
use modava\customer\models\table\CustomerCoSoTable;
use modava\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\CustomerOrder */
/* @var $form yii\widgets\ActiveForm */

Select2Asset::register($this);

$options_price = [];
foreach (ArrayHelper::map(CustomerProductTable::getAll(Yii::$app->language), 'id', 'price') as $id => $price) {
    $options_price[$id] = [
        'price' => $price
    ];
}

$model->ordered_at = date('d-m-Y H:i', $model->ordered_at != null ? is_numeric($model->ordered_at) ? $model->ordered_at : strtotime($model->ordered_at) : time());
if (Yii::$app->controller->action->id == 'create') {
    $validation_url = Url::toRoute(['validate-order', 'customer_id' => $model->customer_id]);
} else {
    $validation_url = Url::toRoute(['validate-order', 'customer_id' => $model->customer_id, 'id' => $model->primaryKey]);
}
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
    <div class="customer-order-form">
        <?php $form = ActiveForm::begin([
            'id' => 'form-order',
            'enableAjaxValidation' => true,
            'validationUrl' => $validation_url
        ]); ?>
        <div class="row">
            <?php if ($model->customer_id == null && Yii::$app->controller->action->id == 'create') { ?>
                <div class="col-md-6 col-12">
                    <?= Select2::widget([
                        'model' => $model,
                        'attribute' => 'customer_id',
                        'data' => ArrayHelper::map(CustomerTable::getCustomerDongY(), 'id', 'name'),
                        'options' => [
                            'prompt' => 'Chọn khách hàng...'
                        ]
                    ]) ?>
                </div>
            <?php } ?>
            <div class="col-md-6 col-12">
                <?= $form->field($model, 'ordered_at')->widget(DateTimePicker::class, [
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
                    else $model->co_so = $model->customerHasOne->co_so;
                }
                ?>
                <?= $form->field($model, 'co_so')->dropDownList(ArrayHelper::map(CustomerCoSoTable::getAllCoSo(), 'id', 'name'), []) ?>
            </div>
        </div>
        <div id="order-info">
            <?= $form->field($model, 'order_detail')->widget(MultipleInput::class, [
                'id' => 'order-detail',
                'max' => 6,
                'allowEmptyList' => false,
                'rowOptions' => [
                    'class' => 'product-row'
                ],
                'columns' => [
                    [
                        'name' => 'order_detail_id',
                        'type' => 'hiddenInput',
                        'title' => CustomerModule::t('customer', 'Order Detail Id'),
                        'enableError' => true,
                        'options' => [
                            'class' => 'hidden',
                        ]
                    ],
                    [
                        'name' => 'product_id',
                        'type' => 'dropdownList',
                        'title' => CustomerModule::t('customer', 'Product ID'),
                        'enableError' => true,
                        'items' => ArrayHelper::map(CustomerProductTable::getAll(Yii::$app->language), 'id', 'name'),
                        'options' => [
                            'prompt' => CustomerModule::t('customer', 'Chọn sản phẩm...'),
                            'class' => 'form-control select-product',
                            'options' => $options_price
                        ]
                    ],
                    [
                        'name' => 'qty',
                        'title' => CustomerModule::t('customer', 'Qty'),
                        'enableError' => true,
                        'defaultValue' => 1,
                        'options' => [
                            'class' => 'product-qty product-change key-change',
                            'type' => 'number',
                            'min' => 1,
                            'step' => 1
                        ]
                    ],
                    [
                        'name' => 'price',
                        'title' => CustomerModule::t('customer', 'Price'),
                        'enableError' => true,
                        'defaultValue' => 0,
                        'options' => [
                            'class' => 'product-price',
                            'readonly' => true
                        ]
                    ],
                    [
                        'name' => 'total_price',
                        'title' => CustomerModule::t('customer', 'Total Price'),
                        'enableError' => true,
                        'defaultValue' => 0,
                        'options' => [
                            'class' => 'product-total-price',
                            'readonly' => true
                        ]
                    ],
                    [
                        'name' => 'discount',
                        'title' => CustomerModule::t('customer', 'Discount'),
                        'enableError' => true,
                        'defaultValue' => 0,
                        'options' => [
                            'class' => 'product-discount product-change key-change',
                            'type' => 'number',
                            'min' => 0
                        ]
                    ],
                    [
                        'name' => 'discount_by',
                        'type' => 'dropdownList',
                        'title' => CustomerModule::t('customer', 'Discount By'),
                        'enableError' => true,
                        'items' => CustomerPayment::DISCOUNT,
                        'defaultValue' => 1,
                        'options' => [
                            'class' => 'product-discount-by product-change'
                        ]
                    ],
                    [
                        'name' => 'reason_discount',
                        'type' => 'textarea',
                        'title' => CustomerModule::t('customer', 'Reason Discount'),
                        'enableError' => true,
                        'options' => [
                            'class' => ''
                        ]
                    ],
                    [
                        'name' => 'total',
                        'title' => CustomerModule::t('customer', 'Total'),
                        'enableError' => true,
                        'defaultValue' => 0,
                        'options' => [
                            'class' => 'product-total',
                            'readonly' => true
                        ]
                    ],
                ]
            ])->label(false);
            ?>
            <div class="row">
                <div class="col-md-6 col-sm-4"></div>
                <div class="col-md-3 col-sm-4 col-12 text-right">
                    Tạm tính:
                </div>
                <div class="col-md-3 col-sm-4 col-12 text-right">
                    <span id="product-tam-tinh"><?= $model->total ?></span>đ
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-4"></div>
                <div class="col-md-3 col-sm-4 col-12 text-right">
                    Chiết khấu:
                </div>
                <div class="col-md-3 col-sm-4 col-12 text-right">
                    <span id="product-chiet-khau"><?= $model->discount ?></span>đ
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-4"></div>
                <div class="col-md-3 col-sm-4 col-12 text-right">
                    Tổng tiền:
                </div>
                <div class="col-md-3 col-sm-4 col-12 text-right">
                    <span id="product-tong-tien"><?= $model->total - $model->discount ?></span>đ
                </div>
            </div>
            <?= $form->field($model, 'total', ['template' => '{error}'])->textInput()->label(false) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton(CustomerModule::t('customer', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>
    </div>
<?php
$discount_by_money = CustomerPayment::DISCOUNT_BY_MONEY;
$discount_by_percent = CustomerPayment::DISCOUNT_BY_PERCENT;
$urlGetProductInfo = Url::toRoute(['/customer/customer-product/get-product-info']);
$script = <<< JS
function getProductInfo(id){
    return new Promise(resolve => {
        $.get('$urlGetProductInfo', {id: id}, res => resolve(res.code === 200 ? res.data : null));
    });
}
function handleOrderRow(row){
    return new Promise(resolve => {
        var price = parseFloat(row.find('.product-price').val() || 0),
            qty = parseInt(row.find('.product-qty').val() || 1),
            discount = parseFloat(row.find('.product-discount').val() || 0),
            discount_by = row.find('.product-discount-by').val() + '' || '$discount_by_money',
            total_price = price * qty,
            total_discount;
        if(discount_by == '$discount_by_percent' && discount > 100) {
            discount = 100;
            row.find('.product-discount').val(discount);
        }
        if(discount_by === '$discount_by_money') {
            total_discount = discount;
        } else {
            total_discount = total_price * discount / 100;
        }
        row.find('.product-price').val(price);
        row.find('.product-total-price').val(total_price);
        row.find('.product-total').val(total_price - total_discount);
        resolve({
            total_price: total_price,
            total_discount: total_discount,
        });
    });
}
async function handleOrder(order_info){
    var total_price = 0,
        total_discount = 0;
    await order_info.find('.product-row').each(function(){
        var row = $(this);
        handleOrderRow(row).then(product => {
            total_price += product.total_price;
            total_discount += product.total_discount;
        });
    });
    order_info.find('#product-tam-tinh').html(total_price);
    order_info.find('#product-chiet-khau').html(total_discount);
    order_info.find('#product-tong-tien').html(total_price - total_discount);
}
$('#order-detail').on('afterInit', function(){
    $('#order-detail .select-product').each(function(){
        $(this).select2();
    });
}).on('afterAddRow', function(){
    $('#order-detail .select-product').each(function(){
        $(this).select2();
    });
}).on('afterDeleteRow', function(e, row, currentIndex){
    handleOrder($('#order-info'));
});
$('#order-info').on('change', '.select-product', function(){
    var id = $(this).val(),
        row = $(this).closest('.product-row');
    getProductInfo(id).then(res => {
        row.find('.product-price').val(res.price);
        handleOrder($('#order-info'));
    });
}).on('change', '.product-change', function(){
    handleOrder($('#order-info'));
}).on('paste keyup', '.key-change', function(){
    handleOrder($('#order-info'));
});
/*
$(function(){
    handleOrder($('#order-info'));
});*/

JS;
$this->registerJs($script, \yii\web\View::POS_END);