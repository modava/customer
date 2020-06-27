<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model modava\customer\models\search\SalesOnlineSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="customer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'birthday') ?>

    <?= $form->field($model, 'sex') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'ward') ?>

    <?php // echo $form->field($model, 'avatar') ?>

    <?php // echo $form->field($model, 'fanpage_id') ?>

    <?php // echo $form->field($model, 'permission_user') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'status_call') ?>

    <?php // echo $form->field($model, 'status_fail') ?>

    <?php // echo $form->field($model, 'status_dat_hen') ?>

    <?php // echo $form->field($model, 'status_dong_y') ?>

    <?php // echo $form->field($model, 'time_lich_hen') ?>

    <?php // echo $form->field($model, 'time_come') ?>

    <?php // echo $form->field($model, 'direct_sale') ?>

    <?php // echo $form->field($model, 'co_so') ?>

    <?php // echo $form->field($model, 'sale_online_note') ?>

    <?php // echo $form->field($model, 'direct_sale_note') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('customer', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('customer', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
