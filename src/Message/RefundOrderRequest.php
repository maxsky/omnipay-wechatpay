<?php

namespace Omnipay\WechatPay\Message;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\WechatPay\Helper;

/**
 * Class RefundOrderRequest
 *
 * @package Omnipay\WechatPay\Message
 * @link    https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_4&index=6
 * @method  RefundOrderResponse send()
 */
class RefundOrderRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://api.mch.weixin.qq.com/secapi/pay/refund';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('app_id', 'mch_id', 'out_trade_no', 'total_fee', 'refund_fee', 'cert_path', 'key_path');

        $data = [
            'appid'           => $this->getAppId(),
            'mch_id'          => $this->getMchId(),
            'sub_appid'       => $this->getSubAppId(),
            'sub_mch_id'      => $this->getSubMchId(),
            'sign_type'       => $this->getSignType(),
            'transaction_id'  => $this->getTransactionId(),
            'out_trade_no'    => $this->getOutTradeNo(),
            'out_refund_no'   => $this->getOutRefundNo(),
            'total_fee'       => $this->getTotalFee(),
            'refund_fee'      => $this->getRefundFee(),
            'refund_fee_type' => $this->getRefundType(),//<>
            'refund_desc'     => $this->getRefundDesc(),
            'notify_url'      => $this->getNotifyUrl(),
            'nonce_str'       => md5(uniqid()),
        ];

        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }


    /**
     * @return string|null
     */
    public function getOutTradeNo(): ?string
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
     * @return string
     */
    public function getOutRefundNo(): string
    {
        return $this->getParameter('out_refund_no');
    }


    /**
     * @param string $outRefundNo
     */
    public function setOutRefundNo(string $outRefundNo)
    {
        $this->setParameter('out_refund_no', $outRefundNo);
    }


    /**
     * @return string|null
     */
    public function getTransactionId(): ?string
    {
        return $this->getParameter('transaction_id');
    }


    /**
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->setParameter('transaction_id', $transactionId);
    }


    /**
     * @return int
     */
    public function getTotalFee(): int
    {
        return (int)$this->getParameter('total_fee');
    }


    /**
     * @param int|string $totalFee
     */
    public function setTotalFee($totalFee)
    {
        $this->setParameter('total_fee', $totalFee);
    }


    /**
     * @return int
     */
    public function getRefundFee(): int
    {
        return (int)$this->getParameter('refund_fee');
    }


    /**
     * @param int|string $refundFee
     */
    public function setRefundFee($refundFee)
    {
        $this->setParameter('refund_fee', $refundFee);
    }


    /**
     * @return string|null
     */
    public function getRefundType(): ?string
    {
        return $this->getParameter('refund_fee_type');
    }


    /**
     * @param string $refundFeeType
     */
    public function setRefundType(string $refundFeeType)
    {
        $this->setParameter('refund_fee_type', $refundFeeType);
    }


    /**
     * @return string|null
     */
    public function getRefundDesc(): ?string
    {
        return $this->getParameter('refund_desc');
    }


    /**
     * @param string $refundDesc
     */
    public function setRefundDesc(string $refundDesc)
    {
        $this->setParameter('refund_desc', $refundDesc);
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

        $result = $client->request('POST', $this->endpoint, $options)->getBody()->getContents();

        $responseData = Helper::xml2array($result);

        return $this->response = new RefundOrderResponse($this, $responseData);
    }
}
