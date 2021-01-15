<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class CompletePurchaseResponse
 *
 * @package Omnipay\WechatPay\Message
 */
class CompletePurchaseResponse extends AbstractResponse
{

    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->isPaid();
    }

    /**
     * @return bool
     */
    public function isPaid(): bool
    {
        $data = $this->getData();

        return $data['paid'];
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
