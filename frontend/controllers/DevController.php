<?php
/**
 * User: Axoford12
 * Date: 2/25/2017
 * Time: 11:44 PM
 */

namespace frontend\controllers;


use common\models\ApiUsedTrait;
use common\models\User;
use yii\base\Controller;

class DevController extends Controller
{
    use ApiUsedTrait;
    public function actionDev(){

        $model = new User();
        print_r($model->getUserOwnedServer(1));
    }

}