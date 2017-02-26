<?php
/**
 * User: Axoford12
 * Date: 2/25/2017
 * Time: 11:47 PM
 */

namespace app\models;


use yii\base\Exception;
use yii\base\Model;

class ApiModel extends Model
{

    /**
     * @var $api
     * 在模型被构造时调用，是一个连接mu的专属对象
     */
    public $api;

    public function __construct($api,array $config = [])
    {
        $this->api = $api;
        parent::__construct($config);
    }

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
        return $this->_getSuccessInfo($this->api->__call($name,$params));
    }


}