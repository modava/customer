<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\widgets\ToastrWidget;
use modava\customer\CustomerModule;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\Customer */
/* @var $form yii\widgets\ActiveForm */
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
<div class="customer-form">
    <?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'birthday')->textInput() ?>

		<?= $form->field($model, 'sex')->textInput() ?>

		<?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'ward')->textInput() ?>

		<?= $form->field($model, 'avatar')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'fanpage_id')->textInput() ?>

		<?= $form->field($model, 'permission_user')->textInput() ?>

		<?= $form->field($model, 'type')->textInput() ?>

		<?= $form->field($model, 'status_call')->textInput() ?>

		<?= $form->field($model, 'status_fail')->textInput() ?>

		<?= $form->field($model, 'status_dat_hen')->textInput() ?>

		<?= $form->field($model, 'status_dong_y')->textInput() ?>

		<?= $form->field($model, 'time_lich_hen')->textInput() ?>

		<?= $form->field($model, 'time_come')->textInput() ?>

		<?= $form->field($model, 'direct_sale')->textInput() ?>

		<?= $form->field($model, 'co_so')->textInput() ?>

		<?= $form->field($model, 'sale_online_note')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'direct_sale_note')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'created_at')->textInput() ?>

		<?= $form->field($model, 'created_by')->textInput() ?>

		<?= $form->field($model, 'updated_at')->textInput() ?>

		<?= $form->field($model, 'updated_by')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton(CustomerModule::t('customer', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>
