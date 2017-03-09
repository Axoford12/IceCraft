<?php
/**
 * User: Axoford12
 * Date: 3/8/2017
 * Time: 12:54 AM
 */

namespace common\models;


use app\models\Order;
use yii\base\Model;
use yii\helpers\Url;
use yii\mutex\OracleMutex;

/**
 * Class DepositForm
 * @package common\models
 * @property $money integer
 */
class DepositForm extends Model
{
    /**
     * @var integer
     * 需要充值的钱数
     */
    public $money;

    /**
     * @param $money integer
     * @return integer
     */
    public function getMoney($money){
        return 0.01;
    }
    public function attributeLabels()
    {
        return ['money' => 'Ice Money'];
    }
    public function rules()
    {
        return [['money' , 'double'],
        ['money','required']];
    }

    /**
     * @param $user_id int
     * 用户ID若用户未登陆将重定向至登陆页面。
     */
    public function startPay($user_id){
        $model = new PayModel();
        $web_root = \Yii::$app->params['IceConfig']['webRoot'];
        $pay_data = $model->startPay($this->getMoney($this->money),
            Url::to(['pay/return'],true), Url::to(['pay/notify'],true));//发起支付
        $order = new Order();
        $order->id = $pay_data['shno'];
        $order->user_id = $user_id;
        $order->status = 0;
        $order->money = $this->money;
        $order->save();
        //重定向到付款页面
        \Yii::$app->response->redirect($pay_data['pay_address']);
    }

}