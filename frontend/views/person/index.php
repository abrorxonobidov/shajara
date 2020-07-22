<?php

use yii\bootstrap\Html;
use yii\grid\GridView;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\person\PersonSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */

$this->title = 'Shaxslar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Html::icon('plus'), ['create'], ['class' => 'btn btn-success', 'title' => 'Shaxs kiritish']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'name',
            'surname',
            'fathers_name',
            //'date_of_birth',
            //'date_of_death',
            //'generation_id',
            //'description',
            //'gender_id',
            //'address',
            //'citizenship',
            //'parent_marriage_id',
            //'education_id',
            //'phone',
            //'profession',
            //'creator_id',
            //'modifier_id',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
