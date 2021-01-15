<?php

namespace Omnipay\WechatPay;

class Helper
{

    /**
     * @param array $arr
     * @param string $root
     * @return string
     */
    public static function array2xml(array $arr, string $root = 'xml'): string
    {
        $xml = "<$root>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";

        return $xml;
    }

    /**
     * @param string $xml
     * @return array
     */
    public static function xml2array(string $xml): array
    {
        libxml_disable_entity_loader(true);

        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        if (!is_array($data)) {
            $data = [];
        }

        return $data;
    }

    /**
     * @param array $data
     * @param string $key
     * @return string
     */
    public static function sign(array $data, string $key): string
    {
        $data = array_filter($data);

        unset($data['sign']);

        ksort($data);

        $result = urldecode(http_build_query($data));
        $result .= "&key={$key}";

        if (($data['sign_type'] ?? 'MD5') === 'MD5') {
            $result = md5($result);
        } else {
            $result = hash_hmac('sha256', $result, $key);
        }

        return strtoupper($result);
    }
}
