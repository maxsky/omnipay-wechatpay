<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class BaseAbstractResponse
 * @package Omnipay\WechatPay\Message
 */
abstract class BaseAbstractResponse extends AbstractResponse
{

    /**
     * Is the response successful?
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        $data = $this->getData();

        return isset($data['result_code']) && $data['result_code'] === 'SUCCESS';
    }
}
