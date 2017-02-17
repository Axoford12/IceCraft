<?php
/**
 * User: Axoford12
 * Date: 2/17/2017
 * Time: 9:32 PM
 */

namespace frontend\controllers;


use app\models\KeyGeneratorForm;
use yii\base\Controller;

class AdminController extends Controller
{

    public function beforeAction($action)
    {
        // 在用户没登录或不为超级用户时，重定向到登录页面
        // It will redirect you to login form
        //  When requester is a guest or not Administrator
        if(\Yii::$app->user->isGuest or \Yii::$app->user->id != 1){
            \Yii::$app->response->redirect(['site/login']);
        }
        return parent::beforeAction($action);
    }
    public function actionCreateKey(){
        $model = new KeyGeneratorForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->generateKey()){
                $num = $model->num;
                return $this->render('keyCreatedSucceed',['num' => $num]);
            }
        }
        return $this->render('keyCreatorForm',['model' => $model]);
    }


}