<?php
/**
 * User: Axoford12
 * Date: 2/17/2017
 * Time: 9:44 PM
 */
$this->title = Yii::t('site', 'key Creator');
?>
<div class="site-key-creater">

    <h1><?= \yii\bootstrap\Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = \yii\bootstrap\ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model,'num')?>

            <div class="form-group">
                <?= \yii\bootstrap\Html::submitButton(Yii::t('site','Submit'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>

            <?php \yii\bootstrap\ActiveForm::end(); ?>
        </div>
    </div>
</div>
