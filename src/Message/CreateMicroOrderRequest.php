<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\WechatPay\Helper;

/**
 * Class CreateMicroOrderRequest
 *
 * @package Omnipay\WechatPay\Message
 * @link    https://pay.weixin.qq.com/wiki/doc/api/micropay.php?chapter=9_10&index=1
 * @method  CreateMicroOrderResponse send()
 */
class CreateMicroOrderRequest extends CreateOrderRequest
{
    protected $endpoint = 'https://api.mch.weixin.qq.com/pay/micropay';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('app_id', 'mch_id', 'body', 'out_trade_no', 'total_fee', 'auth_code');

        $data = array(
            'appid'            => $this->getAppId(),//*
            'mch_id'           => $this->getMchId(),
            'sub_mch_id'       => $this->getSubMchId(),
            'device_info'      => $this->getDeviceInfo(),//*
            'nonce_str'        => md5(uniqid()),//*
            'sign_type'        => $this->getSignType(),
            'body'             => $this->getBody(),//*
            'detail'           => $this->getDetail(),
            'attach'           => $this->getAttach(),
            'out_trade_no'     => $this->getOutTradeNo(),//*
            'fee_type'         => $this->getFeeType(),
            'total_fee'        => $this->getTotalFee(),//*
            'spbill_create_ip' => $this->getSpbillCreateIp(),//*
            'goods_tag'        => $this->getGoodsTag(),
            'limit_pay'        => $this->getLimitPay(),
            'time_start'       => $this->getTimeStart(),
            'time_expire'      => $this->getTimeExpire(),
            'receipt'          => $this->getReceipt(),
            'auth_code'        => $this->getAuthCode(),//*
            'profit_sharing'   => $this->getProfitSharing()
        );

        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }


    /**
     * @return string
     */
    public function getAuthCode(): string
    {
        return $this->getParameter('auth_code');
    }


    /**
     * @param string $authCode
     */
    public function setAuthCode(string $authCode)
    {
        $this->setParameter('auth_code', $authCode);
    }


    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $request = $this->httpClient->request('POST', $this->endpoint, [], Helper::array2xml($data));
        $response = $request->getBody();
        $responseData = Helper::xml2array($response);

        return $this->response = new CreateOrderResponse($this, $responseData);
    }
}
