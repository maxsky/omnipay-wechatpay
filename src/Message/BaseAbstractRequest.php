<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Message\AbstractRequest;

/**
 * Class BaseAbstractRequest
 * @package Omnipay\WechatPay\Message
 */
abstract class BaseAbstractRequest extends AbstractRequest
{

    /**
     * @return string
     */
    public function getAppId(): string
    {
        return $this->getParameter('app_id');
    }


    /**
     * @param string $appId
     */
    public function setAppId(string $appId)
    {
        $this->setParameter('app_id', $appId);
    }


    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->getParameter('api_key');
    }


    /**
     * @return string
     */
    public function getSignType(): string
    {
        return $this->getParameter('sign_type') ?: 'MD5';
    }


    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->setParameter('api_key', $apiKey);
    }


    /**
     * @return mixed
     */
    public function getMchId()
    {
        return $this->getParameter('mch_id');
    }


    /**
     * @param int|string $mchId
     */
    public function setMchId($mchId)
    {
        $this->setParameter('mch_id', $mchId);
    }

    /**
     * @return mixed
     */
    public function getSubMchId()
    {
        return $this->getParameter('sub_mch_id');
    }


    /**
     * @param string $subMchId
     */
    public function setSubMchId(string $subMchId)
    {
        $this->setParameter('sub_mch_id', $subMchId);
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
     * @param string $signType
     */
    public function setSignType(string $signType)
    {
        $this->setParameter('sign_type', strtoupper($signType));
    }
}
