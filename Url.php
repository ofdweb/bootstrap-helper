<?php

namespace razmik\helper;

class Url
{
    public static function toRoute($route, $scheme = false)
    {
        $urlNormalize = static::normalize($route[0]);
        $url = $urlNormalize[0];
        unset ($route[0], $urlNormalize[0]);
        
        $params = array_merge($urlNormalize, $route);

        if ($params) {
            $url .= '?' . http_build_query($params);
        }

        if ($scheme) {
            $url = static::getProtocol($scheme) . $_SERVER['HTTP_HOST'] . $url;
        } 
        return htmlspecialchars_decode($url, ENT_COMPAT);
    }
    
    public static function normalize($url)
    {
        $query = parse_url($url, PHP_URL_QUERY);
        $result = array_merge([parse_url($url, PHP_URL_PATH)], static::queryArray($query));
        return $result;
    }
    
    public static function to($url, $scheme = false)
    {
        if (is_array($url)) {
            return static::toRoute($url, $scheme);
        }

        return $url;
    }
    
    public static function current()
    {
        return $_SERVER["REQUEST_URI"];
    }
    
    public static function currentPath()
    {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }
    
    public static function queryArray($query = null)
    {
        $query = $query ? : $_SERVER["QUERY_STRING"];
        parse_str($query, $output);
        
        return $output;
    }
    
    private static function getProtocol($scheme = false)
    {
        if (is_string($scheme)) {
            return $scheme . '://';
        }
        
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
                return 'https://';
        } else {
            return 'http://';
        }
    }
}