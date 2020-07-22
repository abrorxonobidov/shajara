<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var $this yii\web\View
 * @var $model common\models\marriage\Marriage
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Nikohlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="marriage-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tahrirlash', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('O‘chirish', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Siz rostdan ham ushbu elementni o‘chirmoqchimisiz?',
                'method' => 'post',
            ],
        ]) ?>
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
