<?php

namespace Omnipay\WechatPay\Message;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\WechatPay\Helper;

/**
 * Class PromotionTransferRequest
 *
 * @package Omnipay\WechatPay\Message
 * @link    https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=14_2
 * @method  PromotionTransferResponse send()
 */
class PromotionTransferRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('app_id', 'mch_id', 'partner_trade_no', 'cert_path', 'key_path');

        $data = array(
            'mch_appid'        => $this->getAppId(),
            'mchid'            => $this->getMchId(),
            'device_info'      => $this->getDeviceInfo(),     // <optional>
            'partner_trade_no' => $this->getPartnerTradeNo(),
            'openid'           => $this->getOpenId(),
            'check_name'       => $this->getCheckName(),      // <NO_CHECK or FORCE_CHECK>
            're_user_name'     => $this->getReUserName(),
            'amount'           => $this->getAmount(),
            'desc'             => $this->getDesc(),
            'spbill_create_ip' => $this->getSpbillCreateIp(),
            'nonce_str'        => md5(uniqid()),
        );

        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }


    /**
     * @return string|null
     */
    public function getDeviceInfo(): ?string
    {
        return $this->getParameter('device_Info');
    }


    /**
     * @param string $deviceInfo
     */
    public function setDeviceInfo(string $deviceInfo)
    {
        $this->setParameter('device_Info', $deviceInfo);
    }


    /**
     * @return string
     */
    public function getPartnerTradeNo(): string
    {
        return $this->getParameter('partner_trade_no');
    }


    /**
     * @param mixed $partnerTradeNo
     */
    public function setPartnerTradeNo($partnerTradeNo)
    {
        $this->setParameter('partner_trade_no', $partnerTradeNo);
    }


    /**
     * @return string
     */
    public function getOpenId(): string
    {
        return $this->getParameter('open_id');
    }


    /**
     * @param string $openId
     */
    public function setOpenId(string $openId)
    {
        $this->setParameter('open_id', $openId);
    }


    /**
     * @return string
     */
    public function getCheckName(): string
    {
        return $this->getParameter('check_name');
    }


    /**
     * @param string $checkName
     */
    public function setCheckName(string $checkName)
    {
        $this->setParameter('check_name', $checkName);
    }


    /**
     * @return string|null
     */
    public function getReUserName(): ?string
    {
        return $this->getParameter('re_user_name');
    }


    /**
     * @param string $reUserName
     */
    public function setReUserName(string $reUserName)
    {
        $this->setParameter('re_user_name', $reUserName);
    }


    /**
     * @return int
     */
    public function getAmount(): int
    {
        return (int)$this->getParameter('amount');
    }


    /**
     * @param int|string $amount
     */
    public function setAmount($amount)
    {
        $this->setParameter('amount', $amount);
    }


    /**
     * @return string
     */
    public function getDesc(): string
    {
        return $this->getParameter('desc');
    }


    /**
     * @param string $desc
     */
    public function setDesc(string $desc)
    {
        $this->setParameter('desc', $desc);
    }


    /**
     * @return string|null
     */
    public function getSpbillCreateIp(): ?string
    {
        return $this->getParameter('spbill_create_ip');
    }


    /**
     * @param string $spbillCreateIp
     */
    public function setSpbillCreateIp(string $spbillCreateIp)
    {
        $this->setParameter('spbill_create_ip', $spbillCreateIp);
    }


    /**
     * @return string|null
     */
    public function getCertPath(): ?string
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
     * @return string|null
     */
    public function getKeyPath(): ?string
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
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     * @throws GuzzleException
     */
    public function sendData($data)
    {
        $body = Helper::array2xml($data);
        $client = new Client();

        $options = [
            'body' => $body,
            'verify' => true,
            'cert' => $this->getCertPath(),
            'ssl_key' => $this->getKeyPath(),
        ];
        $response = $client->request('POST', $this->endpoint, $options)->getBody();
        $responseData = Helper::xml2array($response);

        return $this->response = new PromotionTransferResponse($this, $responseData);
    }
}
