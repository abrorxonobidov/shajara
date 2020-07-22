<?php

use yii\bootstrap\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

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
            'husband.fullIdentity',
            'wife.fullIdentity',
            'date_of_marriage',
            'date_of_divorce',
            //'order_husband',
            //'order_wife',
            'description',
            'status',
            //'creator_id',
            //'modifier_id',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <? Pjax::end(); ?>

</div>
