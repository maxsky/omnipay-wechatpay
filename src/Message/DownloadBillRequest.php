<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\WechatPay\Helper;

/**
 * Class DownloadBillRequest
 *
 * @package Omnipay\WechatPay\Message
 * @link    https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_6&index=8
 * @method  DownloadBillResponse send()
 */
class DownloadBillRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://api.mch.weixin.qq.com/pay/downloadbill';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate('app_id', 'mch_id', 'bill_date');

        $data = array(
            'appid' => $this->getAppId(),
            'mch_id' => $this->getMchId(),
            'sub_appid' => $this->getSubAppId(),
            'sub_mch_id' => $this->getSubMchId(),
            'nonce_str' => md5(uniqid()),
            'sign_type' => $this->getSignType(),
            'bill_date' => $this->getBillDate(),
            'bill_type' => $this->getBillType(),//<>
            'tar_type' => $this->getTarType(),//GZIP
        );

        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }


    /**
     * @return string
     */
    public function getBillDate(): string
    {
        return $this->getParameter('bill_date');
    }


    /**
     * @return string|null
     */
    public function getBillType(): ?string
    {
        return $this->getParameter('bill_type');
    }


    /**
     * @return string|null
     */
    public function getTarType(): ?string
    {
        return $this->getParameter('tar_type');
    }


    /**
     * @param string $billDate
     */
    public function setBillDate(string $billDate)
    {
        $this->setParameter('bill_date', $billDate);
    }


    /**
     * @param string $billType
     */
    public function setBillType(string $billType)
    {
        $this->setParameter('bill_type', strtoupper($billType));
    }


    /**
     * @param string $tarType
     */
    public function setTarType(string $tarType)
    {
        $this->setParameter('tar_type', strtoupper($tarType));
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
        $responseData = $this->post($this->endpoint, $data, 120);

        return $this->response = new DownloadBillResponse($this, $responseData);
    }


    /**
     * @param string $url
     * @param array $data
     * @param int $timeout
     * @return array
     */
    private function post(string $url, array $data = array(), int $timeout = 3): array
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, Helper::array2xml($data));
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);

        if (preg_match('#return_code#', $result)) {
            $result = Helper::xml2array($result);
        } else {
            $result = array(['return_code' => 'SUCCESS', 'raw' => $result]);
        }

        return $result;
    }
}
