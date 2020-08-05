<?php

use yii\helpers\Html;
use yii\helpers\Url;
use modava\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\widgets\ToastrWidget;
use modava\customer\CustomerModule;
use modava\customer\models\table\CustomerAgencyTable;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\CustomerOrigin */
/* @var $form yii\widgets\ActiveForm */

if ($model->agencyHasMany != null) {
    $model->agencies = ArrayHelper::map($model->agencyHasMany, 'id', 'id');
}
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
<div class="customer-origin-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= Select2::widget([
        'model' => $model,
        'attribute' => 'agencies',
        'data' => ArrayHelper::map(CustomerAgencyTable::getAllAgency(Yii::$app->language), 'id', 'name'),
        'options' => [
            'class' => 'select2-multiple',
            'multiple' => 'multiple'
        ],
    ]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'language')->dropDownList(['vi' => 'Vi', 'en' => 'En', 'jp' => 'Jp',], []) ?>

    <?php if (Yii::$app->controller->action->id == 'create') $model->status = 1; ?>
    <?= $form->field($model, 'status')->checkbox() ?>
    <div class="form-group">
        <?= Html::submitButton(CustomerModule::t('customer', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
