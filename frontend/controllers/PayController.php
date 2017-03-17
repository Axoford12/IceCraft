<?php

/**
 * User: Axoford12
 * Date: 3/4/2017
 * Time: 6:36 PM
 */
namespace frontend\controllers;

use common\models\PayModel;

class PayController extends \yii\base\Controller
{
    public function actionNotify()
    {
        $model = new PayModel();
        $data = \Yii::$app->request->get() ? \Yii::$app->request->get() : 0;
        if ($data) {
            $model->setAttributes($data,false);
            if ($model->_deposit()) {
                echo 'success';
            }
        }

    }

    public function actionReturn()
    {

    }
}