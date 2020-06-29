<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\search\CustomerOrderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-order-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'customer_id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'total') ?>

    <?= $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'language') ?>

    <?php // echo $form->field($model, 'co_so') ?>

    <?php // echo $form->field($model, 'ordered_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('customer', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('customer', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
