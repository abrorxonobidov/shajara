<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\select2\Select2;

/**
 * @var $this yii\web\View
 * @var $model common\models\marriage\Marriage
 * @var $form yii\widgets\ActiveForm
 */
?>

<div class="marriage-form">

    <? $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-10">
            <?= $form->field($model, 'husband_id')
                ->widget(Select2::class, [
                    'initValueText' => empty($model->husband_id) ? '' : $model->husband->fullIdentity,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("() => { return 'Yuklanmoqda...'; }"),
                        ],
                        'ajax' => [
                            'url' => '/marriage/get-person',
                            'dataType' => 'json',
                            'data' => new JsExpression('(params) => { return {text:params.term, gender_id:1}; }')
                        ],
                        'escapeMarkup' => new JsExpression('(markup) => { return markup; }'),
                        'templateResult' => new JsExpression('(marriage) => { return marriage.text; }'),
                        'templateSelection' => new JsExpression('(marriage) => { return (marriage.text.length > 50) ? marriage.text.substring(0, 50) + " ..." : marriage.text ; }'),
                    ]
                ])
            ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'order_husband')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <?= $form->field($model, 'wife_id')
                ->widget(Select2::class, [
                    'initValueText' => empty($model->wife_id) ? '' : $model->wife->fullIdentity,
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("() => { return 'Yuklanmoqda...'; }"),
                        ],
                        'ajax' => [
                            'url' => '/marriage/get-person',
                            'dataType' => 'json',
                            'data' => new JsExpression('(params) => { return {text:params.term, gender_id:2}; }')
                        ],
                        'escapeMarkup' => new JsExpression('(markup) => { return markup; }'),
                        'templateResult' => new JsExpression('(marriage) => { return marriage.text; }'),
                        'templateSelection' => new JsExpression('(marriage) => { return (marriage.text.length > 50) ? marriage.text.substring(0, 50) + " ..." : marriage.text ; }'),
                    ]
                ])
            ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'order_wife')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'date_of_marriage')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'date_of_divorce')->textInput() ?>
        </div>
    </div>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true, 'rows' => 6, 'placeholder' => 'Eng muhim ma’lumotlarni qisqa shaklda qoldiring ...']) ?>

    <?= $form->field($model, 'status_id')->dropDownList($model::getStatusList(), ['prompt' => 'Statusni tanlang']) ?>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
