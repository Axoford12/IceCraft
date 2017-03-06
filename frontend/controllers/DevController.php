<?php
/**
 * User: Axoford12
 * Date: 2/25/2017
 * Time: 11:44 PM
 */

namespace frontend\controllers;
use common\models\PayModel;
use yii\base\Controller;
class DevController extends Controller
{
    public function actionDev(){

        $model = new PayModel();
        $model->startPay(0.01,'pay/return','pay/notify');
    }

}