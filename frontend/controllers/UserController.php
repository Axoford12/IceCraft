<?php
/**
 * User: Axoford12
 * Date: 3/3/2017
 * Time: 9:26 PM
 */

namespace frontend\controllers;


use common\models\User;
use yii\base\Controller;

class UserController extends Controller
{
    const ACTION_LIST_SERVER = 0;
    const ACTION_MANAGE_SERVER = 1;

    const EVENT_BEFORE_SHOW = -1;
    public function beforeAction($action)
    {
        if(\Yii::$app->user->isGuest){
            \Yii::$app->response->redirect(['/site/index']);
        }
        return parent::beforeAction($action);
    }

    public function actionServer(){
        switch (intval(\Yii::$app->request->get('action',self::ACTION_LIST_SERVER))){
            // 默认情况下显示服务器列表
            case self::ACTION_LIST_SERVER: // 显示服务器列表
                $servers = User::getUserOwnedServer(\Yii::$app->user->id)['server']; // 从本地数据库获得用户所拥有的服务器
                // 将服务器获取到然后渲染页面
                return $this->render('serverList',['servers' => $servers]);
                break;
            case self::ACTION_MANAGE_SERVER: // 管理服务器
                $server_id = \Yii::$app->request->get('server',-1);
                if($server_id == -1){
                    // 如果这个用户乱整，给他重定向到 site / index 路由
                   \Yii::$app->response->redirect(['site/index']);// 使用Yii重定向
                }
                // 开始业务逻辑

        }
        return null;
    }
}