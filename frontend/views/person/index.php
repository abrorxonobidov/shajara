<?php

use yii\bootstrap\Html;
use yii\grid\GridView;
use kartik\daterange\DateRangePicker;
use kartik\select2\Select2;
use common\components\HtmlHelper;
use yii\widgets\Pjax;

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
            ],
            [
                'attribute' => 'generation_id',
                'value' => 'generation',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'generation_id',
                    'data' => $searchModel::getGenerationList(),
                    'options' => ['prompt' => 'Naslni tanlang'],
                    'pluginOptions' => ['allowClear' => true]
                ]),
            ],
            [
                'attribute' => 'gender_id',
                'value' => 'gender',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'gender_id',
                    'data' => $searchModel::getGenderList(),
                    'options' => ['prompt' => 'Jinsni tanlang'],
                    'pluginOptions' => ['allowClear' => true]
                ]),
            ],
            'address',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Html::a(Html::icon('refresh'), ['index'], ['title' => 'Filtrni tozalash']),
            ],
        ],
    ]); ?>

    <? Pjax::end(); ?>

</div>
