<?php

use yii\bootstrap\Html;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use common\components\HtmlHelper;
use yii\widgets\Pjax;
use yii\web\JsExpression;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\person\PersonSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = 'Shaxslar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-index">

    <p class="pull-right"> <?= HtmlHelper::createButton('Shaxs kiritish') ?> </p>

    <h1><?= Html::encode($this->title) ?></h1>

    <? Pjax::begin(); ?>

    <?= GridView::widget([
        'id' => 'person-grid-view',
        'summary' => '<p class="text-right"> {begin} - {end} / {totalCount}</p>',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'fullIdentity',
            [
                'attribute' => 'date_of_birth',
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_of_birth',
                    'convertFormat' => true,
                    'pluginEvents' => [
                        'cancel.daterangepicker' => "function(ev, picker) {\$('#personsearch-date_of_birth').val(''); $('#person-grid-view').yiiGridView('applyFilter');}",
                    ],
                    'pluginOptions' => [
                        'locale' => ['format' => 'Y-m-d'],
                        'allowClear' => true
                    ],
                ]),
                'contentOptions' => ['class' => 'col-md-2']
            ],
            [
                'attribute' => 'date_of_death',
                'filter' => DateRangePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_of_death',
                    'convertFormat' => true,
                    'pluginEvents' => [
                        'cancel.daterangepicker' => "function(ev, picker) {\$('#personsearch-date_of_death').val(''); $('#person-grid-view').yiiGridView('applyFilter');}",
                    ],
                    'pluginOptions' => [
                        'locale' => ['format' => 'Y-m-d'],
                        'allowClear' => true
                    ],
                ]),
                'contentOptions' => ['class' => 'col-md-2']
            ],
            [
                'attribute' => 'generation_id',
                'value' => 'generation',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'generation_id',
                    'data' => $searchModel::getGenerationList(),
                    'options' => ['prompt' => '...'],
                    'pluginOptions' => ['allowClear' => true]
                ]),
                'contentOptions' => ['class' => 'col-md-1']
            ],
            [
                'attribute' => 'gender_id',
                'value' => 'gender',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'gender_id',
                    'data' => $searchModel::getGenderList(),
                    'options' => ['prompt' => '...'],
                    'pluginOptions' => ['allowClear' => true]
                ]),
                'contentOptions' => ['class' => 'col-md-1']
            ],
            [
                'attribute' => 'parent_marriage_id',
                'value' => function ($person) {
                        /** @var $person \common\models\person\Person*/
                        return $person->parent_marriage_id ?
                            Html::a($person->parentMarriage->fullIdentity, ['marriage/view', 'id' => $person->parent_marriage_id], ['target' => "_blank"])
                            : null;
                    },
                'format' => 'raw',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'parent_marriage_id',
                    'initValueText' => empty($searchModel->parent_marriage_id) ? '' : $searchModel->parentMarriage->fullIdentity,
                    'options' => ['placeholder' => 'Ota-onani tanlang'],
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
                        'templateSelection' => new JsExpression('(marriage) => { return (marriage.text.length > 30) ?  marriage.text.substring(0, 30) + " ..." : marriage.text;}'),
                    ]
                ]),
                'contentOptions' => ['class' => 'col-md-2']
            ],
            'address',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a(Html::icon('refresh'), ['index'], ['title' => 'Filtrni tozalash'])
            ]
        ]
    ]); ?>

    <? Pjax::end(); ?>

</div>
