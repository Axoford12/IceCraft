<?php
/**
 * User: Axoford12
 * Date: 2/24/2017
 * Time: 7:50 PM
 */

namespace frontend\controllers;
require_once '../runtime/requirements/MulticraftAPI.php';

use yii\base\Controller;

abstract class ApiUsedBaseController extends Controller
{
    public $api;

    function beforeAction($action)
    {
        if(!isset(\Yii::$app->params['apiConn'])){
            // Throw exception when there is no config found
            // 在没有找到配置文件是抛出异常 .
            throw new Exception(\Yii::t('site','Can not find Api connection information.'));
        }
        $params = \Yii::$app->params['apiConn'];

        // Get Params from params.php
        // 从  params 文件提出一些param参数

        // new A multicraft api connect.
        // set params
        // 开始加载一个api链接，连接到Muticraft的api接口
        // 设置参数为从配置文件读取到的参数
        $this->api = new \MulticraftAPI($params['url'],$params['user'],$params['key']);
        return parent::beforeAction($action);
    }
}