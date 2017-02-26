<?php
/**
 * User: Axoford12
 * Date: 2/25/2017
 * Time: 11:44 PM
 */

namespace frontend\controllers;


use app\models\ApiModel;

class DevController extends ApiUsedBaseController
{
    public function actionDev(){

        $model = new ApiModel($this->api);
        print_r($model->getServer(4));
    }

}