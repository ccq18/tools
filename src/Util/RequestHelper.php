<?php

namespace Util;



class RequestHelper
{

    public static function simpleShowArr($arr, $limit = 999)
    {
       var_dump(static::simpleArr($arr,$limit));
    }

    protected static function simpleArr($arr, $limit = 999)
    {
        if ($limit <= 0) {
            return gettype($arr);
        }
        $rs = [];
        foreach ($arr as $k => $v) {
            if (is_numeric($k) && $k > 1) {
                continue;
            }
            if (is_array($v)) {
                $rs[$k] = static::simpleArr($v, $limit - 1);
            } else {
                $rs[$k] = $v;
            }

        }

        return $rs;
    }

    public static function diffStr($json, $json1, $limit = 1)
    {
        $len = strlen($json);
        for ($i = 0; $i < $len; $i++) {
            if ($json{$i} != $json1{$i}) {
                $limit--;
                $str = $json{$i};
                $str00 = substr($json, $i - 20, 40);
                $str1 = $json1{$i};

                $str10 = substr($json1, $i - 20, 40);
                echo "位置 {$i} ,{$str}!={$str1} [{$str00} ]-[ {$str10}]\n";
                if ($limit <= 0) {
                    break;
                }

            }
        }
    }


    public static function buildUrl($path, $parameters = [])
    {

        $output = static::getUrlParams($path);
        $param_str = http_build_query(array_merge($output, $parameters));
        $param_str = empty($param_str) ? "" : '?' . $param_str;

        return url(ltrim(static::getUrlPath($path), '\/') . $param_str);
    }

    public static function getUrlParams($url)
    {
        $info = parse_url($url);
        $params = isset($info['query']) ? $info['query'] : "";
        parse_str($params, $output);

        return $output;
    }


    public static  function getUrlPath($url)
    {
        if (strpos($url, '?') !== false) {
            $url = substr($url, 0, strpos($url, '?'));
        }

        return $url;
    }


    public static function formatUrlToCode($url){
        $path =static::getUrlPath($url);
        $params = var_export(static::getUrlParams($url), true);
         echo <<<EOF
\$params = {$params};     
\$url = RequestHelper::buildUrl('{$path}', \$params);
EOF;

    }

    public static  function getPageNum($pageCount,$pageSize){
        return ceil($pageCount/$pageSize);
    }

}