<?php

use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model common\models\marriage\Marriage
 */

$this->title = 'Nikoh yaratish';
$this->params['breadcrumbs'][] = ['label' => 'Nikohlar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marriage-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
