<?php
/**
 * User: Axoford12
 * Date: 3/10/2017
 * Time: 10:38 PM
 */
$this->title = Yii::t('site', 'Price');
?>
<link rel="stylesheet" href="/css/price.css" type="text/css">
<?php
foreach ($data['plans'] as $plan) {
    ?>
    <div class="plan">
    <h3 class="plan-title"><?= $plan['title'] ?></h3>
    <p class="plan-price"><?= $plan['price'] ?><span class="plan-unit"><?= $plan['circle'] ?></span></p>
    <ul class="plan-features">
        <?php
        foreach ($plan['feature'] as $datum) { ?>
        <li class="plan-feature"><?= $datum['num'] ?>
            <span class="plan-feature-name"><?= $datum['unit'] ?></span>
            <span class="plan-feature-name"><?= $datum['name'] ?></span>
        </li>
            <?php } ?>
    </ul>
    <a href="#" class="plan-button">Choose Plan</a>
    </div><?php
}
?>