<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\WechatPay\Helper;

/**
 * Class ShortenUrlRequest
 *
 * @package Omnipay\WechatPay\Message
 * @link    https://pay.weixin.qq.com/wiki/doc/api/native.php?chapter=9_9
 * @method  ShortenUrlResponse send()
 */
class ShortenUrlRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://api.mch.weixin.qq.com/tools/shorturl';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('app_id', 'mch_id', 'long_url');

        $data = array(
            'appid'     => $this->getAppId(),
            'mch_id'    => $this->getMchId(),
            'sub_mch_id'=> $this->getSubMchId(),
            'long_url'  => $this->getLongUrl(),
            'sign_type' => $this->getSignType(),
            'nonce_str' => md5(uniqid()),
        );

        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }


    /**
     * @return string
     */
    public function getLongUrl(): string
    {
        return $this->getParameter('long_url');
    }


    /**
     * @param string $longUrl
     */
    public function setLongUrl(string $longUrl)
    {
        $this->setParameter('long_url', $longUrl);
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
        $request      = $this->httpClient->request('POST', $this->endpoint, [], Helper::array2xml($data));
        $response     = $request->getBody();
        $responseData = Helper::xml2array($response);

        return $this->response = new ShortenUrlResponse($this, $responseData);
    }
}
