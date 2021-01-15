<?php

namespace Omnipay\WechatPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\AbstractRequest;

abstract class BaseAbstractGateway extends AbstractGateway
{

    /**
     * @param string $tradeType
     */
    public function setTradeType(string $tradeType)
    {
        $this->setParameter('trade_type', $tradeType);
    }


    /**
     * @return string|null
     */
    public function getTradeType(): ?string
    {
        return $this->getParameter('trade_type');
    }


    /**
     * @param string $appId
     */
    public function setAppId(string $appId)
    {
        $this->setParameter('app_id', $appId);
    }


    /**
     * @return string
     */
    public function getAppId(): string
    {
        return $this->getParameter('app_id');
    }


    /**
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey)
    {
        $this->setParameter('api_key', $apiKey);
    }


    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->getParameter('api_key');
    }


    /**
     * @param int|string $mchId
     */
    public function setMchId($mchId)
    {
        $this->setParameter('mch_id', $mchId);
    }


    /**
     * @return string
     */
    public function getMchId(): string
    {
        return $this->getParameter('mch_id');
    }

    /**
     * 子商户id
     *
     * @return string|null
     */
    public function getSubMchId(): ?string
    {
        return $this->getParameter('sub_mch_id');
    }


    /**
     * @param string $mchId
     */
    public function setSubMchId(string $mchId)
    {
        $this->setParameter('sub_mch_id', $mchId);
    }


    /**
     * 子商户 app_id
     *
     * @return string|null
     */
    public function getSubAppId(): ?string
    {
        return $this->getParameter('sub_appid');
    }


    /**
     * @param string $subAppId
     */
    public function setSubAppId(string $subAppId)
    {
        $this->setParameter('sub_appid', $subAppId);
    }


    /**
     * @param string $url
     */
    public function setNotifyUrl(string $url)
    {
        $this->setParameter('notify_url', $url);
    }


    public function getNotifyUrl()
    {
        return $this->getParameter('notify_url');
    }


    /**
     * @return string
     */
    public function getCertPath(): string
    {
        return $this->getParameter('cert_path');
    }


    /**
     * @param string $certPath
     */
    public function setCertPath(string $certPath)
    {
        $this->setParameter('cert_path', $certPath);
    }


    /**
     * @return string
     */
    public function getKeyPath(): string
    {
        return $this->getParameter('key_path');
    }


    /**
     * @param string $keyPath
     */
    public function setKeyPath(string $keyPath)
    {
        $this->setParameter('key_path', $keyPath);
    }


    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function purchase($parameters = array()): AbstractRequest
    {
        $parameters['trade_type'] = $this->getTradeType();

        return $this->createRequest('\Omnipay\WechatPay\Message\CreateOrderRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function completePurchase($parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\WechatPay\Message\CompletePurchaseRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function completeRefund($parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\WechatPay\Message\CompleteRefundRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function query($parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\WechatPay\Message\QueryOrderRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function close($parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\WechatPay\Message\CloseOrderRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function refund($parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\WechatPay\Message\RefundOrderRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function queryRefund($parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\WechatPay\Message\QueryRefundRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function transfer($parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\WechatPay\Message\PromotionTransferRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function queryTransfer($parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\WechatPay\Message\QueryTransferRequest', $parameters);
    }


    /**
     * @param array $parameters
     *
     * @return AbstractRequest
     */
    public function downloadBill($parameters = array()): AbstractRequest
    {
        return $this->createRequest('\Omnipay\WechatPay\Message\DownloadBillRequest', $parameters);
    }
}
