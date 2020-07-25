<?php

use common\components\HtmlHelper;
use yii\widgets\DetailView;


/**
 * @var $this yii\web\View
 * @var $model common\models\person\Person
 */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Shaxslar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="person-view">

    <h1><?= HtmlHelper::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-12">
            <?= \frontend\widgets\MarriagesGridWidget::widget(['person' => $model])?>
        </div>
        <div class="col-md-6">
            <?= HtmlHelper::img('/images/no_photo.png', ['class' => 'img img-thumbnail']) ?>
            <p class="text-right">
                <?= HtmlHelper::editButton($model) ?>
                <?= HtmlHelper::removeButton($model) ?>
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
                    'parentMarriage.fullIdentity',
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

    </div>

</div>
