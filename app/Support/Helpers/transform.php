<?php

if (!function_exists('arrayToQueryString')) {
    /**
     * 常见的将数组转成query形式的字符串
     *
     * @param array $array
     * @param bool $urlEncode
     * @return string
     */
    function arrayToQueryString(array $array, $urlEncode = true): string
    {
        $string = '';
        ksort($array);
        foreach ($array as $key => $value) {
            $string .= "{$key}={$value}&";
        }
        $string = substr($string, 0, -1);

        return $urlEncode ? urlencode($string) : $string;
    }
}

if (!function_exists('queryStringToArray')) {
    /**
     * 将常见的query形式的字符串转成数组
     *
     * @param $string
     * @param bool $urlDecode
     * @return array
     */
    function queryStringToArray($string, $urlDecode = true): array
    {
        $string = $urlDecode ? urldecode($string) : $string;

        $array = [];
        $pieces = explode('&', $string);
        foreach ($pieces as $piece) {
            list($k, $v) = explode('=', $piece);
            $array[$k] = $v;
        }

        return $array;
    }
}

if (!function_exists('xmlToArray')) {
    /**
     * @param $xmlString
     * @return array
     */
    function xmlToArray($xmlString)
    {
        $objectXml = simplexml_load_string($xmlString, 'SimpleXMLElement', LIBXML_NOCDATA);//将文件转换成 对象
        $xmlJson = json_encode($objectXml );//将对象转换个JSON
        $xmlArray = json_decode($xmlJson,true);//将json转换成数组
        return $xmlArray;
    }
}
