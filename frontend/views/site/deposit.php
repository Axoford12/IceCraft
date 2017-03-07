<?php
/**
 * User: Axoford12
 * Date: 3/8/2017
 * Time: 1:06 AM
 */
?>
<div class="col-lg-9">
    <?php $model = \yii\bootstrap\ActiveForm::begin();?>
    <?= $model->field($deposit,'money')->textInput(); ?>
    <?= \yii\bootstrap\Html::submitButton('Submit',['class' => 'btn btn-primary']);?>
    <?php \yii\bootstrap\ActiveForm::end() ?>

</div>
<div class="col-lg-3"></div>
