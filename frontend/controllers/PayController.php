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
    public function actionNotify(){
        $model = new PayModel();
        if($model->setAttributes(\Yii::$app->request->get()) && $model->validate()){
            if($model->afterPay()){
                echo 'success';
            }
        }

    }

    public function actionReturn(){
        $model = new PayModel();
        if($model->setAttributes(\Yii::$app->request->get()) && $model->validate()){
            if($model->afterPay()){
                echo 'success';
            }
        }
    }
}