<?php

namespace Omnipay\WechatPay\Message;

/**
 * Class ShortenUrlResponse
 *
 * @package Omnipay\WechatPay\Message
 * @link    https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_9#5
 */
class ShortenUrlResponse extends BaseAbstractResponse
{
    public function getShortUrl()
    {
        $data = $this->getData();

        return isset($data['short_url']) ? $data['short_url'] : null;
    }
}
