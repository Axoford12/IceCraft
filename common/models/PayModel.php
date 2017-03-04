<?php
/**
 * User: Axoford12
 * Date: 3/4/2017
 * Time: 6:44 PM
 */

namespace common\models;


use yii\base\Model;

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
     * @param $data
     * @return string
     */
    private function _base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }


    /**
     * @return bool
     * 返回用户直接重定向页面的验证成功与否
     */
    private function _returnFunc()
    {
        $decode = $this->_base64url_decode($this->sign);
        $pu_key = openssl_pkey_get_public($this->rsakey);

        openssl_public_decrypt($decode, $design, $pu_key);
        $signde = explode('|', $design);
        if ($signde[1] === $this->shno) {
            return true;
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
        $decode = $this->_base64url_decode($this->sign);
        $pu_key = openssl_pkey_get_public($this->rsakey);
        openssl_public_decrypt($decode, $design, $pu_key);
        $signde = explode('|', $design);

        if ($signde[1] === $this->shno) {
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
}