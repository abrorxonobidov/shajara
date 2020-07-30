<?php

use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\web\JsExpression;
use kartik\daterange\DateRangePicker;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\marriage\MarriageSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = 'Nikohlar';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="marriage-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Html::icon('plus'), ['create'], ['class' => 'btn btn-success', 'title' => 'Nikoh yaratish']) ?>
    </p>

    <? Pjax::begin(); ?>

    <?= GridView::widget([
        'id' => 'marriage-grid-view',
        'summary' => '<p class="text-right"> {begin} - {end} / {totalCount}</p>',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'identity_search_id',
                'value' => function ($model) {
                    /** @var $model \common\models\marriage\Marriage*/
                    return str_replace('-', '- <br>', $model->fullIdentity);
                },
                'label' => 'Er va xotin',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'identity_search_id',
                    'initValueText' => empty($searchModel->identity_search_id) ? '' : $searchModel->person->fullIdentity,
                    'options' => [
                        'placeholder' => 'Shaxs F.I.Sh',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'minimumInputLength' => 3,
                        'language' => [
                            'errorLoading' => new JsExpression("() => { return 'Yuklanmoqda...'; }"),
                        ],
                        'ajax' => [
                            'url' => '/marriage/get-person',
                            'dataType' => 'json',
                            'data' => new JsExpression('(params) => { return {text:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('(markup) => { return markup; }'),
                        'templateResult' => new JsExpression('(marriage) => { return marriage.text; }'),
                        'templateSelection' => new JsExpression('(marriage) => { return (marriage.text.length > 50) ? marriage.text.substring(0, 50) + " ..." : marriage.text ; }'),
                    ]
                ]),
                'contentOptions' => [
                    'class' => 'col-md-4',
                ],
                'format' => 'raw'
            ],
            [
                'attribute' => 'date_of_marriage',
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_of_marriage',
                    'convertFormat' => true,
                    'pluginEvents' => [
                        'cancel.daterangepicker' => "function(ev, picker) {\$('#marriagesearch-date_of_marriage').val(''); $('#marriage-grid-view').yiiGridView('applyFilter');}",
                    ],
                    'pluginOptions' => [
                        'locale' => ['format' => 'Y-m-d'],
                        'allowClear' => true
                    ],
                ]),
            ],
            [
                'attribute' => 'date_of_divorce',
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_of_divorce',
                    'convertFormat' => true,
                    'pluginEvents' => [
                        'cancel.daterangepicker' => "function(ev, picker) {\$('#marriagesearch-date_of_divorce').val(''); $('#marriage-grid-view').yiiGridView('applyFilter');}",
                    ],
                    'pluginOptions' => [
                        'locale' => ['format' => 'Y-m-d'],
                        'allowClear' => true
                    ],
                ]),
            ],
            [
                'attribute' => 'status_id',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status_id',
                    'data' => $searchModel::getStatusList(),
                    'options' => ['prompt' => 'Statusni tanlang'],
                    'pluginOptions' => ['allowClear' => true]
                ]),
                'value' => 'status'
            ],
            'description',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <? Pjax::end(); ?>

</div>
