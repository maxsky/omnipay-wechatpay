<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\WechatPay\Helper;

/**
 * Class CreateOrderResponse
 *
 * @package Omnipay\WechatPay\Message
 * @link    https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_1#5
 */
class CreateOrderResponse extends BaseAbstractResponse
{

    /**
     * @var CreateOrderRequest
     */
    protected $request;


    /**
     * @return array
     */
    public function getAppOrderData(): array
    {
        if ($this->isSuccessful()) {
            $data = [
                'appid'     => $this->request->getAppId(),
                'partnerid' => $this->request->getMchId(),
                'prepayid'  => $this->getPrepayId(),
                'package'   => 'Sign=WXPay',
                'noncestr'  => md5(uniqid()),
                'timestamp' => time(),
            ];

            $data['sign'] = Helper::sign($data, $this->request->getApiKey());
        } else {
            $data = null;
        }

        return $data;
    }


    /**
     * @return string|null
     */
    public function getPrepayId(): ?string
    {
        if ($this->isSuccessful()) {
            $data = $this->getData();

            return $data['prepay_id'];
        }

        return null;
    }


    /**
     * @return array
     */
    public function getJsOrderData(): array
    {
        if ($this->isSuccessful()) {
            $data = [
                'appId'     => $this->request->getAppId(),
                'package'   => 'prepay_id=' . $this->getPrepayId(),
                'nonceStr'  => md5(uniqid()),
                'timeStamp' => time() . '',
            ];

            $data['signType'] = 'MD5';
            $data['paySign']  = Helper::sign($data, $this->request->getApiKey());
        } else {
            $data = null;
        }

        return $data;
    }


    /**
     * @return string|null
     */
    public function getCodeUrl(): ?string
    {
        if ($this->isSuccessful() && $this->request->getTradeType() == 'NATIVE') {
            $data = $this->getData();

            return $data['code_url'];
        }

        return null;
    }


    /**
     * @return string|null
     */
    public function getMwebUrl(): ?string
    {
        if ($this->isSuccessful() && $this->request->getTradeType() == 'MWEB') {
            $data = $this->getData();

            return $data['mweb_url'];
        }

        return null;
    }
}
