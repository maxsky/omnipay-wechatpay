<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\WechatPay\Helper;

/**
 * Class CreateMicroOrderResponse
 *
 * @package Omnipay\WechatPay\Message
 */
class CreateMicroOrderResponse extends BaseAbstractResponse
{

    /**
     * @var CreateOrderRequest
     */
    protected $request;

    /**
     * @return array
     */
    public function getOrderData(): array
    {
        if ($this->isSuccessful()) {
            $data = [
                'app_id'    => $this->request->getAppId(),
                'mch_id'    => $this->request->getMchId(),
                'prepay_id' => $this->getPrepayId(),
                'package'   => 'Sign=WXPay',
                'nonce'     => md5(uniqid()),
                'timestamp' => time() . '',
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
            return $this->getData()['prepay_id'];
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getCodeUrl(): ?string
    {
        if ($this->isSuccessful() && $this->request->getTradeType() == 'NATIVE') {
            return $this->getData()['code_url'];
        }

        return null;
    }
}
