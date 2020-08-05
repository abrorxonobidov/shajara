<?php

use yii\bootstrap\Html;
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

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'surname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'fathers_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">

        <div class="col-md-3">
            <?= $form->field($model, 'generation_id')->dropDownList($model::getGenerationList(), ['prompt' => 'Naslni tanlang']) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'gender_id')->dropDownList($model::getGenderList(), ['prompt' => 'Jinsni tanlang']) ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'date_of_birth')
                ->widget(DatePicker::class, [
                    'type' => 3,
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true,
                        'todayHighlight' => true
                    ],
                    'layout' => '{input}{remove}{picker}' .
                        Html::tag('span', Html::icon('alert'), [
                            'class' => 'input-group-addon',
                            'role' => 'button',
                            'data-toggle' => 'collapse',
                            'href' => '#collapse_date_of_death',
                            'aria-expanded' => 'false',
                            'aria-controls' => 'collapse_date_of_death',
                            'title' => $model->getAttributeLabel('date_of_death')
                        ]),
                ]) ?>
        </div>

        <div class="col-md-3">
            <div class="collapse" id="collapse_date_of_death">
                <?= $form->field($model, 'date_of_death')
                    ->widget(DatePicker::class, [
                        'type' => 3,
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true
                        ]
                    ]) ?>
            </div>
        </div>

    </div>


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
                    'url' => '/person/get-marriage',
                    'dataType' => 'json',
                    'data' => new JsExpression('(params) => { return {text:params.term, id:null}; }')
                ],
                'escapeMarkup' => new JsExpression('(markup) => { return markup; }'),
                'templateResult' => new JsExpression('(marriage) => { return marriage.text; }'),
                'templateSelection' => new JsExpression('(marriage) => { return marriage.text;}'),
            ]
        ])
    ?>


    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'education_id')->dropDownList($model::getEducationList(), ['prompt' => 'Ma’lumotini tanlang']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'profession')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'citizenship_id')->dropDownList($model::getCitizenshipList()) ?>
        </div>

    </div>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true, 'rows' => 6, 'placeholder' => 'Eng muhim ma’lumotlarni qisqa shaklda qoldiring ...']) ?>

    <? //= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
