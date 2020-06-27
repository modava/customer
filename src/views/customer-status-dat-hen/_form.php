<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\widgets\ToastrWidget;
use modava\customer\CustomerModule;
use modava\customer\models\CustomerStatusDatHen;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\CustomerStatusDatHen */
/* @var $form yii\widgets\ActiveForm */

if (Yii::$app->controller->action->id == 'create') {
    $model->accept = $model->status = CustomerStatusDatHen::STATUS_PUBLISHED;
}
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
<div class="customer-status-dat-hen-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6 col-12">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6 col-12">
            <?= $form->field($model, 'language')->dropDownList(['vi' => 'Vi', 'en' => 'En', 'jp' => 'Jp'], []) ?>
        </div>
    </div>
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    <div class="row">
        <div class="col-md-6 col-12">
            <?= $form->field($model, 'accept')->dropDownList([
                CustomerStatusDatHen::STATUS_DISABLED => CustomerModule::t('customer', 'Đặt hẹn không đến'),
                CustomerStatusDatHen::STATUS_PUBLISHED => CustomerModule::t('customer', 'Đặt hẹn đến'),
            ], []) ?>
        </div>
    </div>
    <?= $form->field($model, 'status')->checkbox() ?>
    <div class="form-group">
        <?= Html::submitButton(CustomerModule::t('customer', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
