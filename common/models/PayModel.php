<?php
/**
 * User: Axoford12
 * Date: 3/4/2017
 * Time: 6:44 PM
 */

namespace common\models;
include_once '../../frontend/requirements/Fpay.php';

use yii\base\Model;
use yii\helpers\Url;

/**
 * Class PayModel
 * @package common\models
 * @property $sign
 * @property $money
 * @property $id
 * @property $shno
 * @property $rsakey
 * @property $partner
 */
class PayModel extends Model
{
    /**
     * @var string
     * 签名注册的字符串
     */
    public $sign;

    /**
     * @var integer
     * 付款的钱数
     */
    public $money;

    /**
     * @var int
     * id
     *
     */
    public $id;

    /**
     * @var int
     * 付款完成的shno参数
     */
    public $shno;

    /**
     * @var string
     * RSA公钥
     */
    private $rsakey;

    /**
     * @var int
     * 合作公钥
     */
    private $partner;


    // ---参数定义完成---
    //
    //
    // 一下为函数定义
    // ---------------

    /**
     * 从配置文件读取Fpay的信息
     */
    private function _getFpay()
    {
        $this->partner = \Yii::$app->params['Fpay']['partner'];
        $this->rsakey = \Yii::$app->params['Fpay']['rsakey'];
    }


    /**
     * 构造方法
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->_getFpay();
        parent::__construct($config);
    }


    /**
     * @return bool
     * 返回用户直接重定向页面的验证成功与否
     */
    private function _returnFunc()
    {
        $fpay = self::getFpay();
        if ($fpay->checkReturnData($this->sign,$this->money,$this->shno)
            && $fpay->getUserPayStatus($this->shno)) {
            return 'success';
        } else {
            return false;
        }
    }

    /**
     * @return bool|string
     * 返回付款成功后的成功与否
     */
    private function _notifyFunc()
    {
        $fpay = self::getFpay();
        if ($fpay->checkReturnData($this->sign,$this->money,$this->shno)
            && $fpay->getUserPayStatus($this->shno)) {
            return 'success';
        } else {
            return false;
        }

    }

    /**
     * @param $action
     * @return bool|string
     * 获取订单状态
     */
    public function getStatus($action){
        if($action == 'notify'){
            return $this->_notifyFunc();
        } else if ($action == 'return'){
            return $this->_returnFunc();
        }
        return false;
    }

    /**
     * @return \Fpay
     * 返回Fpay对象
     */
    public static function getFpay(){
        $partner = \Yii::$app->params['Fpay']['partner'];
        $rsakey = \Yii::$app->params['Fpay']['rsakey'];
        $fpay = new \Fpay($partner,$rsakey);
        return $fpay;
    }
    /**
     * @param $money integer
     * @param $return_url string
     * 用户返回地址
     * @param $notify_url string
     * 异步返回地址
     *
     * 本次付款所要求的钱数
     */
    public function startPay($money,$return_url,$notify_url){
        $web_root = \Yii::$app->params['IceConfig']['webRoot'];
        self::getFpay()->toPayByUser($money,
            $web_root . Url::to([$return_url]),
            $web_root . Url::to([$notify_url]),'pay_by_user');

    }
}