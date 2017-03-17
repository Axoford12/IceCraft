<?php
/**
 * User: Axoford12
 * Date: 3/17/2017
 * Time: 8:40 PM
 */
?>
<style type="text/css">
    #log {
        width: 90%;
        margin: 0 auto;
        overflow: scroll;
        height: 400px;
    }
</style>
<script>
    while (true){

        var log = $.ajax({
           'url' : "/user/get-log"
        });
        $('#log').html(log.responseText);
    }
    function console() {

    }
</script>
<div class="col-lg-9">
    <div class="manage">
        <input type="text"><button class="btn btn-primary" onclick="console"><?=Yii::t('site','Submit')?></button>
        <textarea id="log" disabled="disabled" readonly="readonly"></textarea>
    </div>
</div>
<div class="col-lg-3"></div>