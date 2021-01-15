<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\WechatPay\Helper;

/**
 * Class CloseOrderRequest
 *
 * @package Omnipay\WechatPay\Message
 * @link    https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_3&index=5
 * @method  CloseOrderResponse send()
 */
class CloseOrderRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://api.mch.weixin.qq.com/pay/closeorder';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('app_id', 'mch_id', 'out_trade_no');

        $data = array(
            'appid'        => $this->getAppId(),
            'mch_id'       => $this->getMchId(),
            'sub_appid'    => $this->getSubAppId(),
            'sub_mch_id'   => $this->getSubMchId(),
            'out_trade_no' => $this->getOutTradeNo(),
            'nonce_str'    => md5(uniqid()),
        );

        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }


    /**
     * @return string
     */
    public function getOutTradeNo(): string
    {
        return $this->getParameter('out_trade_no');
    }


    /**
     * @param string $outTradeNo
     */
    public function setOutTradeNo(string $outTradeNo)
    {
        $this->setParameter('out_trade_no', $outTradeNo);
    }


    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $body     = Helper::array2xml($data);
        $response = $this->httpClient->request('POST', $this->endpoint, [], $body)->getBody();
        $payload  = Helper::xml2array($response);

        return $this->response = new CloseOrderResponse($this, $payload);
    }
}
