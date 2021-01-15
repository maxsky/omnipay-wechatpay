<?php

namespace Omnipay\WechatPay;

use Omnipay\Common\Message\{AbstractRequest, NotificationInterface, RequestInterface};

/**
 * Class PosGateway
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
class PosGateway extends BaseAbstractGateway
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'WechatPay Pos';
    }


    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function purchase($parameters = array()): AbstractRequest
    {
        $parameters['trade_type'] = $this->getTradeType();

        return $this->createRequest('\Omnipay\WechatPay\Message\CreateMicroOrderRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function queryOpenId($parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\WechatPay\Message\QueryOpenIdByAuthCodeRequest', $parameters);
    }
}
