<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\web\JsExpression;
use kartik\select2\Select2;

/**
 * @var $this yii\web\View
 * @var $model common\models\person\Person
 * @var $form yii\widgets\ActiveForm
 */
?>

<div class="person-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fathers_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_birth')
        ->widget(DatePicker::class, [
            'type' => 3,
            'pluginOptions' => [
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
                'todayHighlight' => true
            ]
        ]) ?>

    <?= $form->field($model, 'date_of_death')
        ->widget(DatePicker::class, [
            'type' => 3,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true
            ]
        ]) ?>

    <?= $form->field($model, 'generation_id')->dropDownList($model::getGenerationList(), ['prompt' => 'Naslni tanlang']) ?>

    <?= $form->field($model, 'gender_id')->dropDownList($model::getGenderList(), ['prompt' => 'Jinsni tanlang']) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'citizenship_id')->dropDownList($model::getCitizenshipList()) ?>

    <?= $form->field($model, 'parent_marriage_id')
        ->widget(Select2::class, [
            'initValueText' => empty($model->parent_marriage_id) ? '' : $model->parentMarriage->fullIdentity,
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 3,
                'language' => [
                    'errorLoading' => new JsExpression("() => { return 'Yuklanmoqda...'; }"),
                ],
                'ajax' => [
                    'url' => 'get-marriage',
                    'dataType' => 'json',
                    'data' => new JsExpression('(params) => { return {text:params.term, id:null}; }')
                ],
                'escapeMarkup' => new JsExpression('(markup) => { return markup; }'),
                'templateResult' => new JsExpression('(marriage) => { return marriage.text; }'),
                'templateSelection' => new JsExpression('(marriage) => { return marriage.text;}'),
            ]
        ])
    ?>

    <?= $form->field($model, 'education_id')->dropDownList($model::getEducationList(), ['prompt' => 'Ma’lumotini tanlang']) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profession')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true, 'rows' => 6, 'placeholder' => 'Eng muhim ma’lumotlarni qisqa shaklda qoldiring ...']) ?>

    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
