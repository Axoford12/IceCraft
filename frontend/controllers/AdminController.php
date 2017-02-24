<?php
/**
 * User: Axoford12
 * Date: 2/17/2017
 * Time: 9:32 PM
 */

namespace frontend\controllers;


use app\models\KeyGeneratorForm;
use app\models\ServerModel;
use common\models\User;
use yii\base\Controller;

class AdminController extends ApiUsedBaseController
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
        // Get data mod
        // 获得数据模型
        $model = new KeyGeneratorForm();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            // Get url request and validate
            // sql
            // 获取得到的数据并使其经过验证器
            if($model->generateKey()){
                // 生成key成功后渲染页面
                $num = $model->num;
                return $this->render('keyCreatedSucceed',['num' => $num]);
            }
        }
        return $this->render('keyCreatorForm',['model' => $model]);
    }

   public function actionServerCreate(){
        // 创建服务器 仅创建与面板数据库
       // Create server
       // In this panel database only
       
   }

   public function actionImport(){
       $action = intval(\Yii::$app->request->get('action','0'));
       $model = new ServerModel();
       $model->api = $this->api;
       print_r($model->import($action));
   }


}