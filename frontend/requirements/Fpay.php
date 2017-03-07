<?php
function base64url_decode($data)
{
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function base64url_encode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

/**
 * Class Fpay
 * @property $partner
 * @property $rsakey
 */
class Fpay
{
    public $partner;
    public $rsakey;

    /**
     * Fpay constructor.
     * @param $partner
     * 合作ID
     * @param $rsakey
     * RSA Key
     */
    public function __construct($partner, $rsakey)
    {
        $this->partner = $partner;
        $this->rsakey = $rsakey;
    }

    /**
     * @param $money
     * 金额
     * @param $return_url
     * 返回地址
     * @param $notify_url
     * 异步地址
     * @param $type
     * 类型
     * @return array
     * 返回数据数组
     */
    public function toPayByUser($money, $return_url, $notify_url, $type)
    {
        $rand = date("YmdHis") . mt_rand(100000, 999999);
        $pu_key = openssl_pkey_get_public($this->rsakey);
        $sign = $money . '|' . $rand . '|' . $return_url . '|' . $notify_url;
        openssl_public_encrypt($sign, $ensign, $pu_key);//公钥加密
        $pay_address = 'https://pay.mcpe.cc/Gateway.do?'
            . 'partner=' . $this->partner
            . '&money=' . $money
            . '&shno=' . $rand
            . '&sign=' . base64url_encode($ensign)
            . '&type=' . $type;
        $data = ['shno' => $rand,'pay_address' => $pay_address];

        return $data;
    }

    /**
     * @param $sign
     * 签名
     * @param $money
     * 金额
     * @param $shno
     * shno
     * @return bool
     * 返回检查是否成功
     */
    function checkReturnData($sign, $money, $shno)
    {
        $pu_key = openssl_pkey_get_public($this->rsakey);
        $decode = base64url_decode($sign);
        openssl_public_decrypt($decode, $design, $pu_key);
        $data = $money . '|' . $shno . '|' . $this->partner;
        if ($design === $data) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $shno
     * shno
     * @return bool
     */
    function getUserPayStatus($shno)
    {
        $encode = $shno . '|' . $this->partner;
        $pu_key = openssl_pkey_get_public($this->rsakey);
        openssl_public_encrypt($encode, $ensign, $pu_key);
        $status = file_get_contents('https://pay.mcpe.cc/Gateway.do?partner='
            . $this->partner
            . '&sign=' . base64url_encode($ensign)
            . '&type=get_user_pay_status');
        if ($status === 'ok') {
            return true;
        } else {
            return false;
        }
    }
}
