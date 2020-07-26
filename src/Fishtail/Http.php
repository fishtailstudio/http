<?php

namespace Fishtail;

/**
 * Http请求类
 * @author wenyu wenyutech@foxmail.com
 */
class Http
{
    public $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.61 Safari/537.36';
    /**
     * GET请求方法
     * @param string $url 请求的url
     * @param string $cookie 请求cookie
     * @param array $header 请求头数据
     * @param int $returnCookie 是否返回cookie
     * @return string|array $returnCookie==0时，返回请求返回内容；$returnCookie==1时，返回请求返回内容content和cookie
     */
    static function get($url, $cookie = '', $header = [], $returnCookie = 0)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);
        if ($header) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        if ($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $res = curl_exec($curl);
        if (curl_errno($curl)) { //请求出错
            return curl_error($curl);
        }
        curl_close($curl);
        if ($returnCookie) {
            list($header, $body) = explode("\r\n\r\n", $res, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/i", $header, $matches); //匹配相应cookie
            $cookie = '';
            foreach ($matches[1] as $value) {
                $cookie = $value . ';' . $cookie;
            }
            $info['cookie']  = preg_replace('# #', '', $cookie);
            $info['content'] = $body;
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
     * @param string $returnCookie 是否返回cookie
     * @return string|array $returnCookie==0时，返回请求返回内容；$returnCookie==1时，返回请求返回内容content和cookie
     */
    static function post($url, $data, $cookie = '', $header = [], $returnCookie = 0)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->userAgent);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        if ($header) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        }
        if ($cookie) {
            curl_setopt($curl, CURLOPT_COOKIE, $cookie);
        }
        curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $res = curl_exec($curl);
        if (curl_errno($curl)) { //请求出错
            return curl_error($curl);
        }
        curl_close($curl);
        if ($returnCookie) {
            list($header, $body) = explode("\r\n\r\n", $res, 2);
            preg_match_all("/Set\-Cookie:([^;]*);/i", $header, $matches); //匹配相应cookie
            $cookie = '';
            foreach ($matches[1] as $value) {
                $cookie = $value . ';' . $cookie;
            }
            $info['cookie']  = preg_replace('# #', '', $cookie);
            $info['content'] = $body;
            return $info;
        } else {
            return $res;
        }
    }
}
