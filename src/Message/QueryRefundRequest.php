<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\WechatPay\Helper;

/**
 * Class QueryRefundRequest
 *
 * @package Omnipay\WechatPay\Message
 * @link    https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_5&index=7
 * @method  QueryRefundResponse send()
 */
class QueryRefundRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://api.mch.weixin.qq.com/pay/refundquery';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('app_id', 'mch_id');

        $queryIdEmpty = !$this->getTransactionId() && !$this->getOutTradeNo();
        $queryIdEmpty = ($queryIdEmpty && !$this->getOutRefundNo() && !$this->getRefundId());

        if ($queryIdEmpty) {
            $message = "The 'transaction_id' or 'out_trade_no' or 'out_refund_no' or 'refund_id' parameter is required";
            throw new InvalidRequestException($message);
        }

        $data = array(
            'appid'          => $this->getAppId(),
            'mch_id'         => $this->getMchId(),
            'sub_appid'      => $this->getSubAppId(),
            'sub_mch_id'     => $this->getSubMchId(),
            'transaction_id' => $this->getTransactionId(),
            'out_trade_no'   => $this->getOutTradeNo(),
            'out_refund_no'  => $this->getOutRefundNo(),
            'refund_id'      => $this->getRefundId(),
            'offset'         => $this->getOffset(),
            'nonce_str'      => md5(uniqid()),
        );

        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }


    /**
     * @return string|null
     */
    public function getTransactionId(): ?string
    {
        return $this->getParameter('transaction_id');
    }


    /**
     * @return string|null
     */
    public function getOutTradeNo(): ?string
    {
        return $this->getParameter('out_trade_no');
    }


    /**
     * @return string|null
     */
    public function getOutRefundNo(): ?string
    {
        return $this->getParameter('out_refund_no');
    }


    /**
     * @return string|null
     */
    public function getRefundId(): ?string
    {
        return $this->getParameter('refund_id');
    }


    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->getParameter('offset');
    }


    /**
     * @param string $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->setParameter('transaction_id', $transactionId);
    }


    /**
     * @param string $outTradeNo
     */
    public function setOutTradeNo(string $outTradeNo)
    {
        $this->setParameter('out_trade_no', $outTradeNo);
    }


    /**
     * @param string $outRefundNo
     */
    public function setOutRefundNo(string $outRefundNo)
    {
        $this->setParameter('out_refund_no', $outRefundNo);
    }


    /**
     * @param string $refundId
     */
    public function setRefundId(string $refundId)
    {
        $this->setParameter('refund_id', $refundId);
    }


    /**
     * @param int $offset
     */
    public function setOffset(int $offset)
    {
        $this->setParameter('offset', $offset);
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

        return $this->response = new QueryRefundResponse($this, $responseData);
    }
}
