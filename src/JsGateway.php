<?php

namespace Omnipay\WechatPay;

use Omnipay\Common\Message\{NotificationInterface, RequestInterface};

/**
 * Class JsGateway
 * @package Omnipay\WechatPay
 * @method NotificationInterface acceptNotification(array $options = array())
 * @method RequestInterface authorize(array $options = array())
 * @method RequestInterface completeAuthorize(array $options = array())
 * @method RequestInterface capture(array $options = array())
 * @method RequestInterface fetchTransaction(array $options = [])
 * @method RequestInterface void(array $options = array())
 * @method RequestInterface createCard(array $options = array())
 * @method RequestInterface updateCard(array $options = array())
 * @method RequestInterface deleteCard(array $options = array())
 */
class JsGateway extends BaseAbstractGateway
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'WechatPay JS API/MP';
    }


    /**
     * @return string
     */
    public function getTradeType(): string
    {
        return 'JSAPI';
    }
}
