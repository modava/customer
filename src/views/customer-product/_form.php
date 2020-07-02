<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\widgets\ToastrWidget;
use modava\customer\CustomerModule;
use modava\customer\models\table\CustomerProductCategoryTable;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\CustomerProduct */
/* @var $form yii\widgets\ActiveForm */
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
<div class="customer-product-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= Select2::widget([
        'model' => $model,
        'attribute' => 'category_id',
        'data' => ArrayHelper::map(CustomerProductCategoryTable::getAll(), 'id', 'name'),
        'options' => [
            'prompt' => $model->getAttributeLabel('category_id')
        ]
    ]) ?>

    <?= $form->field($model, 'price')->input('number', [
        'step' => 1,
        'min' => 0
    ]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true, 'rows' => 5]) ?>

    <?= $form->field($model, 'language')->dropDownList(['vi' => 'Vi', 'en' => 'En', 'jp' => 'Jp'], []) ?>

    <?php if (Yii::$app->controller->action->id == 'create') $model->status = 1; ?>
    <?= $form->field($model, 'status')->checkbox() ?>
    <div class="form-group">
        <?= Html::submitButton(CustomerModule::t('customer', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
