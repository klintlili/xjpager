<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use backend\models\Pics;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\PicsSearch */
/* @var $form kartik\form\ActiveForm */
?>

<div class="pics-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
        'fieldConfig' => ['autoPlaceholder'=>true]
    ]); ?>

    <div class="row">
        <div class="col-lg-1">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col-lg-2">
<!--            autocomplete设置为off，可以让浏览器取消提示及之前的记录-->
            <?=$form->field($model, 'title')->textInput(['autocomplete' => 'off']) ?>
        </div>
        <div class="col-lg-2">
            <?php
            // Implement a feedback icon
            echo $form->field($model, 'origin_url', [
                'feedbackIcon' => [
                    'default' => 'envelope',
                    'success' => 'ok',
                    'error' => 'exclamation-sign',
                    'defaultOptions' => ['class'=>'text-primary']
                ]
            ])->textInput(['placeholder'=>'Enter a valid url address...']);?>
        </div>
        <div class="col-lg-2">
<!--            默认显示的是第一个option内容，select本身是没有placeholder的-->
<!--            --><?php //echo $form->field($model, 'type')->dropDownList(Pics::$types, ['prompt' => '']) ?>
            <?= $form->field($model, 'type')->widget(Select2::class, [
                'data' => Pics::$types,
                'language' => 'zh',
                'options' => ['placeholder' => 'Select a type ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model, 'created_at', [
                'addon'=>['prepend'=>['content'=>'<i class="fas fa-calendar-alt"></i>']],
                'options'=>['class'=>'drp-container form-group']
            ])->widget(DateRangePicker::class,[
                'options' => ['autocomplete' => 'off', 'placeholder' => 'Select range...'],
                'presetDropdown' =>true,
                'convertFormat' => true,
                'useWithAddon' => true,
                'includeMonthsFilter'=>true,
                'hideInput' => false,
                //'value' => '2018-10-04 - 2018-11-14',
                'startInputOptions' => ['value' => '2017-06-11'],
                'endInputOptions' => ['value' => '2017-07-20'],
//                'startAttribute' => 'datetime_min',
//                'endAttribute' => 'datetime_max',
//                'readonly' => true,
//                'disabled' => true,
                'pluginOptions' => [
                    'timePicker'=>true,
                    'timePickerIncrement'=>30,
                    'locale'=>[
                        'format'=>'Y-m-d h:i A',
                        //'format' => 'Y-n-j',
                        'separator'=>' to ',
                    ],
                    'opens'=>'right',
                    'showDropdowns'=>true, //月年可以select选择
                ],
            ]); ?>
        </div>
    </div>

    <div class="form-group row" style="text-align: center">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('重置所选条件', ['index'], ['class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
