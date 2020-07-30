<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\components\HtmlHelper;

/**
 * @var $this yii\web\View
 * @var $model common\models\marriage\Marriage
 */

$this->title = $model->fullIdentity;
$this->params['breadcrumbs'][] = ['label' => 'Nikohlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="marriage-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="pull-right">
        <?= HtmlHelper::createButton() ?>
        <?= HtmlHelper::editButton($model) ?>
        <?= HtmlHelper::removeButton($model) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'husband.fullIdentity',
            'wife.fullIdentity',
            'date_of_marriage',
            'date_of_divorce',
            'order_husband',
            'order_wife',
            'description',
            'status',
            'creator.nameAndSurname',
            'created_at',
            'modifier.nameAndSurname',
            'updated_at',
        ],
    ]) ?>

</div>
