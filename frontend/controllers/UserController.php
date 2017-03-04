<?php
/**
 * User: Axoford12
 * Date: 3/3/2017
 * Time: 9:26 PM
 */

namespace frontend\controllers;


use yii\base\Controller;

class UserController extends Controller
{

    public function beforeAction($action)
    {
        if(\Yii::$app->user->isGuest){
            \Yii::$app->response->redirect(['/site/index']);
        }
        return parent::beforeAction($action);
    }

    public function actionServerList(){

    }
}