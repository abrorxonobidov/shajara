<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\person\Person */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Shaxslar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="person-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tahrirlash', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('O‘chirish', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ushbu yozuvni o‘chirishni istaysizmi?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'name',
            'surname',
            'fathers_name',
            'date_of_birth',
            'date_of_death',
            'generation',
            'description',
            'gender',
            'address',
            'citizenship',
            'parent_marriage_id',
            'education',
            'phone',
            'profession',
            'creator.nameAndSurname',
            'created_at',
            'modifier.nameAndSurname',
            'updated_at',
        ],
    ]) ?>

</div>
