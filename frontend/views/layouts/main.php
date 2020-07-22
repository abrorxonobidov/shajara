<?php

/**
 * @var $this \yii\web\View
 * @var $content string
 */

use yii\helpers\Html;
use frontend\assets\AppAsset;

AppAsset::register($this);

$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <? $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <? $this->head() ?>
</head>
<body>

<? $this->beginBody() ?>

<?= $this->render('_left_menu', [
    'content' => $content
]) ?>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
    </div>
</footer>

<? $this->endBody() ?>
</body>
</html>
<? $this->endPage() ?>
