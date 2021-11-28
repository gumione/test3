<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">404</h1>

        <p class="lead"><?= Yii::t('app', 'Page not found :(') ?></p>
        
        <p class="lead"><a href="/"><?= Yii::t('app', 'Home') ?></a></p>
    </div>

</div>
