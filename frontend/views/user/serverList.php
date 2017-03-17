<?php
/**
 * User: Axoford12
 * Date: 3/3/2017
 * Time: 9:30 PM
 */
?>
<style type="text/css">
    .items{
        opacity: 0.8;
        background-color: #d0eded;
    }
    .item{
        opacity: 1;
        margin: 0 auto;
    }
    .class-name {
        color: #00aa00;
    }
</style>
<div class="col-lg-9">
    <div class="row">
        <h1>我的服务器:</h1>
        <h4>(点击管理)</h4>
        <div class="items">
            <?php foreach ($servers as $server){?>
            <div class="item">
                <p class="class-name"
                   align="center"
                   onclick="window.location.href='?server=<?=$server['id']?>'
                           +'&action=<?=\frontend\controllers\UserController::ACTION_MANAGE_SERVER?>'">
                    <?= $server['name'].' '.Yii::$app->formatter->asDatetime($server['time'],'yyyy-MM-dd')
                    ?>
                </p>
            </div>
            <?php }?>
        </div>
    </div>
</div>
<div class="col-lg-3"></div>
