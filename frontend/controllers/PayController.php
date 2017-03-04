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
    /**
     * @var PayModel
     */
    private $model;
    private function _base64url_decode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
    private function _base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function beforeAction($action)
    {
        $this->model =  new PayModel();
        return parent::beforeAction($action);
    }

    public function actionNotify(){
        $model = $this->model;
        $model->setAttributes(\Yii::$app->request->get(),false);
        echo $model->getStatus('notify');
    }

    public function actionReturn(){
        $model = $this->model;
        $model->setAttributes(\Yii::$app->request->get(),false);
        echo $model->getStatus('return');
    }
}