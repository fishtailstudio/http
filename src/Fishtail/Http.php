<?php

namespace Fishtail;

/**
 * Http请求类
 * @author wenyu wenyutech@foxmail.com
 */
class Http
{
    // User-Agent
    static $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36';
    // 请求超时时间
    static $timeout = 30;
    /**
     * GET请求方法
     * @param string $url 请求的url
     * @param string $cookie 请求cookie
     * @param array $header 请求头数据
     * @param bool $returnCookie 是否返回cookie
     * @return string|array $returnCookie为假时，返回body；$returnCookie为真时，返回包含body和cookie的数组
     */
    static function get($url, $cookie = '', $header = [], $returnCookie = false)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, self::$timeout);
        curl_setopt($curl, CURLOPT_USERAGENT, self::$userAgent);
        if ($header) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        if ($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        $res = curl_exec($curl);
        if (curl_errno($curl)) { //请求出错
            return curl_error($curl);
        }
        curl_close($curl);
        if ($returnCookie) {
            list($header, $body) = explode("\r\n\r\n", $res, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/i", $header, $matches); //匹配cookie
            $cookie = '';
            foreach ($matches[1] as $value) {
                $cookie = $value . ';' . $cookie;
            }
            $info['cookie']  = preg_replace('# #', '', $cookie);
            $info['body'] = $body;
            return $info;
        } else {
            return $res;
        }
    }

    /**
     * POST请求方法
     * @param string $url 请求的url
     * @param string|array $data post数据
     * @param string $cookie 请求cookie
     * @param array $header 请求头数据
     * @param bool $returnCookie 是否返回cookie
     * @return string|array $returnCookie为假时，返回body；$returnCookie为真时，返回包含body和cookie的数组
     */
    static function post($url, $data, $cookie = '', $header = [], $returnCookie = false)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_USERAGENT, self::$userAgent);
        curl_setopt($curl, CURLOPT_TIMEOUT, self::$timeout);
        if ($header) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        if ($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        $res = curl_exec($curl);
        if (curl_errno($curl)) { //请求出错
            return curl_error($curl);
        }
        curl_close($curl);
        if ($returnCookie) {
            list($header, $body) = explode("\r\n\r\n", $res, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/i", $header, $matches); //匹配cookie
            $cookie = '';
            foreach ($matches[1] as $value) {
                $cookie = $value . ';' . $cookie;
            }
            $info['cookie']  = preg_replace('# #', '', $cookie);
            $info['body'] = $body;
            return $info;
        } else {
            return $res;
        }
    }
}
