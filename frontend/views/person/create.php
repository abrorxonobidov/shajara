<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\person\Person
 */

$this->title = 'Shaxs kiritish';
$this->params['breadcrumbs'][] = ['label' => 'Shaxslar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
