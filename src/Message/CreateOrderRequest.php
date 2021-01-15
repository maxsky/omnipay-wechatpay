<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Http\Exception\{NetworkException, RequestException};
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\WechatPay\Helper;

/**
 * Class CreateOrderRequest
 *
 * @package Omnipay\WechatPay\Message
 * @link    https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_1
 * @method  CreateOrderResponse send()
 */
class CreateOrderRequest extends BaseAbstractRequest
{
    protected $endpoint = 'https://api.mch.weixin.qq.com/pay/unifiedorder';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return array
     * @throws InvalidRequestException
     */
    public function getData(): array
    {
        $this->validate(
            'app_id',
            'mch_id',
            'body',
            'out_trade_no',
            'total_fee',
            'notify_url',
            'trade_type',
            'spbill_create_ip'
        );

        $tradeType = strtoupper($this->getTradeType());

        if ($tradeType == 'JSAPI') {
            $this->validate('open_id');
        }

        $data = array(
            'appid'            => $this->getAppId(),//*
            'mch_id'           => $this->getMchId(),
            'sub_appid'        => $this->getSubAppId(),
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
            'time_start'       => $this->getTimeStart(),//yyyyMMddHHmmss
            'time_expire'      => $this->getTimeExpire(),//yyyyMMddHHmmss
            'goods_tag'        => $this->getGoodsTag(),
            'notify_url'       => $this->getNotifyUrl(), //*
            'trade_type'       => $this->getTradeType(), //*
            'limit_pay'        => $this->getLimitPay(),
            'receipt'          => $this->getReceipt(),
            'profit_sharing'   => $this->getProfitSharing(),
            'openid'           => $this->getOpenId(),//*(trade_type=JSAPI)
        );

        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }


    /**
     * @return string
     */
    public function getTradeType(): string
    {
        return $this->getParameter('trade_type');
    }


    /**
     * @return string|null
     */
    public function getDeviceInfo(): ?string
    {
        return $this->getParameter('device_Info');
    }


    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->getParameter('body');
    }


    /**
     * @return string|null
     */
    public function getDetail(): ?string
    {
        return $this->getParameter('detail');
    }


    /**
     * @return string|null
     */
    public function getAttach(): ?string
    {
        return $this->getParameter('attach');
    }


    /**
     * @return string
     */
    public function getOutTradeNo(): string
    {
        return $this->getParameter('out_trade_no');
    }


    /**
     * @return string|null
     */
    public function getFeeType(): ?string
    {
        return $this->getParameter('fee_type');
    }


    /**
     * @return int
     */
    public function getTotalFee(): int
    {
        return (int)$this->getParameter('total_fee');
    }


    /**
     * @return string
     */
    public function getSpbillCreateIp(): string
    {
        return $this->getParameter('spbill_create_ip');
    }


    /**
     * @return string|null
     */
    public function getTimeStart(): ?string
    {
        return $this->getParameter('time_start');
    }


    /**
     * @return string|null
     */
    public function getTimeExpire(): ?string
    {
        return $this->getParameter('time_expire');
    }


    /**
     * @return string|null
     */
    public function getGoodsTag(): ?string
    {
        return $this->getParameter('goods_tag');
    }


    /**
     * @return string
     */
    public function getNotifyUrl(): string
    {
        return $this->getParameter('notify_url');
    }


    /**
     * @return string|null
     */
    public function getLimitPay(): ?string
    {
        return $this->getParameter('limit_pay');
    }


    /**
     * @return string|null
     */
    public function getReceipt(): ?string
    {
        return $this->getParameter('receipt');
    }


    /**
     * @return string|null
     */
    public function getProfitSharing(): ?string
    {
        return $this->getParameter('profit_sharing');
    }


    /**
     * @return string|null
     */
    public function getOpenId(): ?string
    {
        return $this->getParameter('open_id');
    }


    /**
     * @param string $deviceInfo
     */
    public function setDeviceInfo(string $deviceInfo)
    {
        $this->setParameter('device_Info', $deviceInfo);
    }


    /**
     * @param string $body
     */
    public function setBody(string $body)
    {
        $this->setParameter('body', $body);
    }


    /**
     * @param string $detail
     */
    public function setDetail(string $detail)
    {
        $this->setParameter('detail', $detail);
    }


    /**
     * @param string $attach
     */
    public function setAttach(string $attach)
    {
        $this->setParameter('attach', $attach);
    }


    /**
     * @param string $outTradeNo
     */
    public function setOutTradeNo(string $outTradeNo)
    {
        $this->setParameter('out_trade_no', $outTradeNo);
    }


    /**
     * @param string $feeType
     */
    public function setFeeType(string $feeType)
    {
        $this->setParameter('fee_type', $feeType);
    }


    /**
     * @param int|string $totalFee
     */
    public function setTotalFee($totalFee)
    {
        $this->setParameter('total_fee', $totalFee);
    }


    /**
     * @param mixed $spbillCreateIp
     */
    public function setSpbillCreateIp($spbillCreateIp)
    {
        $this->setParameter('spbill_create_ip', $spbillCreateIp);
    }


    /**
     * @param string $timeStart
     */
    public function setTimeStart(string $timeStart)
    {
        $this->setParameter('time_start', $timeStart);
    }


    /**
     * @param string $timeExpire
     */
    public function setTimeExpire(string $timeExpire)
    {
        $this->setParameter('time_expire', $timeExpire);
    }


    /**
     * @param string $goodsTag
     */
    public function setGoodsTag(string $goodsTag)
    {
        $this->setParameter('goods_tag', $goodsTag);
    }


    /**
     * @param string $notifyUrl
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->setParameter('notify_url', $notifyUrl);
    }


    /**
     * @param string $tradeType
     */
    public function setTradeType(string $tradeType)
    {
        $this->setParameter('trade_type', $tradeType);
    }


    /**
     * @param string $limitPay
     */
    public function setLimitPay(string $limitPay)
    {
        $this->setParameter('limit_pay', $limitPay);
    }


    /**
     * @param string $receipt
     */
    public function setReceipt(string $receipt)
    {
        $this->setParameter('receipt', $receipt);
    }


    /**
     * @param string $profitSharing
     */
    public function setProfitSharing(string $profitSharing)
    {
        $this->setParameter('profit_sharing', $profitSharing);
    }


    /**
     * @param string $openId
     */
    public function setOpenId(string $openId)
    {
        $this->setParameter('open_id', $openId);
    }


    /**
     * Send the request with specified data
     *
     * @param mixed $data The data to send
     *
     * @return ResponseInterface
     * @throws NetworkException|RequestException
     */
    public function sendData($data)
    {
        $body = Helper::array2xml($data);
        $response = $this->httpClient->request('POST', $this->endpoint, [], $body)->getBody();
        $payload = Helper::xml2array($response);

        return $this->response = new CreateOrderResponse($this, $payload);
    }
}
