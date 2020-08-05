<?php

use common\components\HtmlHelper;
use yii\widgets\DetailView;


/**
 * @var $this yii\web\View
 * @var $model common\models\person\Person
 */

$this->title = $model->fullIdentity;
$this->params['breadcrumbs'][] = ['label' => 'Shaxslar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="person-view">

    <p class="pull-right">
        <?= HtmlHelper::createButton('Hosil qilish', 'create', '') ?>
        <?= HtmlHelper::editButton($model) ?>
        <?= HtmlHelper::removeButton($model) ?>
    </p>

    <h1><?= HtmlHelper::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-3">
            <?= HtmlHelper::img('/images/no_photo.png', ['class' => 'img img-thumbnail']) ?>
        </div>
        <div class="col-md-3">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'title',
                    'name',
                    'surname',
                    'fathers_name',
                    'date_of_birth',
                    'date_of_death'
                ]
            ]) ?>
        </div>
        <div class="col-md-3">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'generation',
                    'description',
                    'gender',
                    'address',
                    'citizenship',
                    [
                        'attribute' => 'parentMarriage.fullIdentity',
                        'value' => $model->parent_marriage_id ? HtmlHelper::a($model->parentMarriage->fullIdentity, ['marriage/view', 'id' => $model->parent_marriage_id]) : null,
                        'format' => 'html'
                    ]
                ]
            ]) ?>
        </div>
        <div class="col-md-3">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'education',
                    'phone',
                    'profession',
                    'creator.nameAndSurname',
                    'created_at',
                    'modifier.nameAndSurname',
                    'updated_at'
                ]
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= \frontend\widgets\MarriagesGridWidget::widget(['person' => $model]) ?>
        </div>
    </div>
</div>
