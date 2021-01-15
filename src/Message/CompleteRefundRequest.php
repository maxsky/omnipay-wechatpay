<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\WechatPay\Helper;

/**
 * Class CompleteRefundRequest
 *
 * @package Omnipay\WechatPay\Message
 * @link    https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_16&index=11
 * @method  CompleteRefundResponse send()
 */
class CompleteRefundRequest extends BaseAbstractRequest
{

    /**
     * @param array|string $requestParams
     */
    public function setRequestParams($requestParams)
    {
        $this->setParameter('request_params', $requestParams);
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
        $data = $this->getData();
        $sign = Helper::sign($data, $this->getApiKey());

        $responseData = array();

        if (isset($data['sign']) && $data['sign'] && $sign === $data['sign']) {
            $responseData['sign_match'] = true;
        } else {
            $responseData['sign_match'] = false;
        }

        if ($responseData['sign_match'] && isset($data['refund_status']) && $data['refund_status'] == 'SUCCESS') {
            $responseData['refunded'] = true;
        } else {
            $responseData['refunded'] = false;
        }

        return $this->response = new CompleteRefundResponse($this, $responseData);
    }

    public function getData()
    {
        $data = $this->getRequestParams();

        if (is_string($data)) {
            $data = Helper::xml2array($data);
        }

        // 微信: 退款结果对重要的数据进行了加密
        if (isset($data['req_info'])) {
            $encrypted_data = openssl_decrypt(
                base64_decode($data['req_info']),
                'AES-256-ECB',
                md5($this->getApiKey()),
                OPENSSL_RAW_DATA
            );

            if (is_string($encrypted_data)) {
                unset($data['req_info']);
                $data = array_merge($data, Helper::xml2array($encrypted_data));
            }
        }

        return $data;
    }


    /**
     * @return array|string
     */
    public function getRequestParams()
    {
        return $this->getParameter('request_params');
    }
}
