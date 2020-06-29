<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Select2;
use yii\widgets\ActiveForm;
use backend\widgets\ToastrWidget;
use modava\customer\CustomerModule;
use yii\helpers\ArrayHelper;
use modava\customer\components\CustomerDateTimePicker;
use modava\customer\models\table\CustomerTable;
use modava\customer\models\table\CustomerOrderTable;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\CustomerTreatmentSchedule */
/* @var $form yii\widgets\ActiveForm */

if($model->time_start != null){
    $model->time_start = date('d-m-Y H:i', $model->time_start);
}
if($model->time_end != null){
    $model->time_end = date('d-m-Y H:i', $model->time_end);
}
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
<div class="customer-treatment-schedule-form">
    <?php $form = ActiveForm::begin(); ?>
    <?php if($model->order_id == null && Yii::$app->controller->action->id == 'create'){ ?>
    <div class="row">
        <div class="col-md-6 col-12">
            <?= Select2::widget([
                'model' => $model,
                'attribute' => 'customer_id',
                'data' => ArrayHelper::map(CustomerTable::getCustomerDongY(), 'id', 'name'),
                'options' => [
                    'class' => 'form-control load-data-on-change',
                    'load-data-element' => '#select-order',
                    'load-data-url' => Url::toRoute(['/customer/customer-order/get-order-by-customer']),
                    'load-data-key' => 'customer_id',
                    'load-data-callback' => '',
                    'load-data-method' => 'GET'
                ]
            ]) ?>
        </div>
        <div class="col-md-6 col-12" id="select-order-content">
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
            <?= $form->field($model, 'time_start')->widget(CustomerDateTimePicker::class, [
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
            <?= $form->field($model, 'time_end')->widget(CustomerDateTimePicker::class, [
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
    </div>

    <?= $form->field($model, 'note')->textarea(['rows' => 6, 'maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(CustomerModule::t('customer', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
