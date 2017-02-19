<?php

/**
 * User: Axoford12
 * Date: 2/19/2017
 * Time: 1:23 PM
 */
?>
<div class="col-lg-9">
    <?php $form = \yii\bootstrap\ActiveForm::begin();?>

    <?=$form->field($model,'type')->dropDownList($types);?>
    <!-- 获取下拉类型 -->

    <?= $form->field($model,'param')->textInput()?>
</div>
<div class="col-lg-3"></div>
