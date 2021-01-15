<?php

namespace Omnipay\WechatPay;

use Omnipay\Common\Message\{NotificationInterface, RequestInterface};

/**
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
class AppGateway extends BaseAbstractGateway
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'WechatPay App';
    }


    /**
     * @return string
     */
    public function getTradeType(): string
    {
        return 'APP';
    }
}
