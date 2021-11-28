<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Alert;

$this->title = Yii::$app->name;

?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4"><?= Yii::t('app', 'Hey there!') ?></h1>

        <p class="lead"><?= Yii::t('app', 'Let\'s create some shortlinks!') ?></p>
    </div>

    <div class="body-content">
        <?= Alert::widget() ?>
        <div class="row">
            <div class="col-lg-12">
                <?php
                $form = ActiveForm::begin([
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => false,
                        'validationUrl' => '/site/validate-link',
                        'fieldConfig' => [
                            'template' => "{input}\n{error}",
                            'errorOptions' => ['class' => 'text-danger']
                        ]
                ]);

                ?>
                <?= $form->field($model, 'full_url')->textInput(['type' => 'text', 'class' => 'form-control', 'placeholder' => Yii::t('app', 'Link')]) ?>
                <?= $form->field($model, 'limit')->textInput(['type' => 'number', 'class' => 'form-control', 'placeholder' => Yii::t('app', 'Clicks limit (use 0 to disable limit)')]) ?>
                <div class="row">
                    <div class="col-12">
                        <h5><small><?= Yii::t('app', 'Link lifetime (24 hrs max)') ?></small></h5>
                    </div>
                </div>
                <div class="row">
                    <?= $form->field($model, 'ttl_hrs', ['options' => ['class' => 'form-group col-4']])->textInput(['value' => '24', 'minlength' => 1, 'maxlength' => 2, 'class' => 'form-control', 'placeholder' => Yii::t('app', 'hours')]) ?>
                    <?= $form->field($model, 'ttl_min', ['options' => ['class' => 'form-group col-4']])->textInput(['value' => '00', 'minlength' => 1, 'maxlength' => 2, 'class' => 'form-control', 'placeholder' => Yii::t('app', 'minutes')]) ?>
                    <?= $form->field($model, 'ttl_sec', ['options' => ['class' => 'form-group col-4']])->textInput(['value' => '00', 'minlength' => 1, 'maxlength' => 2, 'class' => 'form-control', 'placeholder' => Yii::t('app', 'seconds')]) ?>
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>

<?php
                
$this->registerJs(
    "$(document).ready(function(){
        $('.btn-copy').click(function(){
            navigator.clipboard.writeText($(this).attr('data-contents'));
            $(this).text('" . Yii::t('app', 'Copied!') ."');
        })
    })", 3);