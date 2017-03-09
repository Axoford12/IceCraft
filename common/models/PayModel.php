<?php
/**
 * User: Axoford12
 * Date: 3/4/2017
 * Time: 6:44 PM
 */

namespace common\models;
include_once '../../frontend/requirements/Fpay.php';

use app\models\Order;
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
     * 构造方法
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->_getFpay();
        parent::__construct($config);
    }

    /**
     * @return \Fpay
     * 返回Fpay对象
     */
    private static function _getFpay(){
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
     * @return array
     * 数据数组
     * 本次付款所要求的钱数
     */
    public function startPay($money,$return_url,$notify_url){
        $data = self::_getFpay()->toPayByUser($money,
            $return_url,
            $notify_url,'pay_by_user');

        return $data;
    }


    /**
     * 设计为用户充值成功后调用。
     */
    public function afterPay(){

    }

    /**
     * @return bool
     * 返回操作是否成功和有效
     */
    private function _deposit(){
        $fpay = self::_getFpay();
        if ($fpay->checkReturnData($this->sign,$this->money,$this->shno)
            && $fpay->getUserPayStatus($this->shno)) {
            // 检查有关pay参数


            $order = Order::find()
                ->select(['id','user_id','money','status'])
                ->where(['id' => $this->shno])
                ->one();// 从数据库中找到一条能和此订单匹配的记录
            // 从数据库中找到的数据进行如下操作

            if(!($order->status)){
                // 订单未被处理过，即用户已付款但金额未到账

                // 将状态设置为已处理
                $order->status = 1;
                $order->save();// 使用活动记录保存修改
                $user = User::findOne($order['user_id']);// 根据User Id找到订单的对应用户
                $user->money = $user->money + $order['money'];
                // 为用户进行充值
                $user->save();//保存数据记录
            }

            return true;// 充值成功 返回true
        } else {
            // 用户可能是重复调用了这个接口 ，返回失败状态。
            return false;
        }
    }
}