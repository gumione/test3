<?php

use yii\helpers\Url;
?>

<?= Yii::t('app', 'Here is your link: ') ?>
<?= Url::to("/{$token}", 'https') ?>

<a class="btn btn-sm btn-primary btn-copy" data-contents="<?= Url::to("/{$token}", 'https') ?>">
    <?=Yii::t('app', 'Copy to clipboard')?>
</a>