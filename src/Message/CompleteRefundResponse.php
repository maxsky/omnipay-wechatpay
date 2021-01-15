<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class CompleteRefundResponse
 *
 * @package Omnipay\WechatPay\Message
 */
class CompleteRefundResponse extends AbstractResponse
{

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->isRefunded();
    }

    /**
     * @return bool
     */
    public function isRefunded(): bool
    {
        $data = $this->getData();

        return $data['refunded'];
    }

    /**
     * @return bool
     */
    public function isSignMatch(): bool
    {
        $data = $this->getData();

        return $data['sign_match'];
    }


    public function getRequestData()
    {
        return $this->request->getData();
    }
}
