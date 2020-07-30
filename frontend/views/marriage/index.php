<?php

use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\select2\Select2;
use yii\web\JsExpression;

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
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'identity_search_id',
                'value' => 'fullIdentity',
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
                ])
            ],
            //'husband.fullIdentity',
            //'wife.fullIdentity',
            'date_of_marriage',
            'date_of_divorce',
            //'order_husband',
            //'order_wife',
            //'description',
            [
                'attribute' => 'status_id',
                'filter' => Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'status_id',
                    'data' => $searchModel::getStatusList(),
                    'options' => [
                        'prompt' => 'Statusni tanlang'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ]
                ]),
                'value' => 'status'
            ],
            //'creator_id',
            //'modifier_id',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <? Pjax::end(); ?>

</div>
