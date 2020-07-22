<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model common\models\person\Person
 */

$this->title = 'Shaxsni tahrirlash: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Shaxslar', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Tahrirlash';
?>
<div class="person-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
