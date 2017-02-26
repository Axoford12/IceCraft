<?php
/**
 * User: Axoford12
 * Date: 2/27/2017
 * Time: 12:17 AM
 */

namespace common\models;
require_once '../../frontend/runtime/requirements/MulticraftAPI.php';

use yii\base\Exception;

trait ApiUsedTrait
{

    /**
     * @var $api
     * 在模型被构造时调用，是一个连接mu的专属对象
     */
    public $api;


    /**
     * 获取成功的返回值，如果为success为true则返回data
     * 如果success为false则抛出异常并返回error数组
     * @param $api_answer
     * 一般传入api请求 。请求的返回结果会被此方法进行处理
     * @return mixed
     * 当api调用成功时返回data数组
     * @throws Exception
     * api调用失败时抛出异常。
     */
    private function _getSuccessInfo($api_answer){
        if($api_answer['success']){
            // 请求调用成功
            return $api_answer['data'];
        } else {

            throw new Exception(\Yii::t('site', 'Cannot get api data:') . $api_answer['errors'][0]);
        }
    }

    /**
     * @param string $name
     * @param array $params
     * @return mixed
     * 返回已经成功检查的值
     */
    public function __call($name, $params)
    {
        $this->api = $this->_getApi();
        return $this->_getSuccessInfo($this->api->__call($name,$params));
    }

    /**
     * @return object 返回Multicraft API对象
     * @throws Exception 当获取不到配置文件时抛出异常
     */
    private function _getApi(){
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
        return new \MulticraftAPI($params['url'],$params['user'],$params['key']);
    }
}