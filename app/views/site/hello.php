<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Привет мир)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        Привет мир, привет <?= $yiiName ?>!
    </p>

    <code><?= __FILE__ ?> -- это можно убрать в коде =))</code>
</div>