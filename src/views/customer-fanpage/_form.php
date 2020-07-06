<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use modava\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\widgets\ToastrWidget;
use modava\customer\CustomerModule;
use modava\customer\models\table\CustomerOriginTable;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\CustomerFanpage */
/* @var $form yii\widgets\ActiveForm */
?>
<?= ToastrWidget::widget(['key' => 'toastr-' . $model->toastr_key . '-form']) ?>
<div class="customer-fanpage-form">
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= Select2::widget([
        'model' => $model,
        'attribute' => 'origin_id',
        'data' => ArrayHelper::map(CustomerOriginTable::getAllOrigin(Yii::$app->language), 'id', 'name'),
        'options' => [
            'prompt' => CustomerModule::t('social', 'Chọn nguồn trực tuyến...')
        ]
    ]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'url_page')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'language')->dropDownList(['vi' => 'Vi', 'en' => 'En', 'jp' => 'Jp',], []) ?>

    <?php if (Yii::$app->controller->action->id == 'create') $model->status = 1; ?>
    <?= $form->field($model, 'status')->checkbox() ?>
    <div class="form-group">
        <?= Html::submitButton(CustomerModule::t('customer', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
