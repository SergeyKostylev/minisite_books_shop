<?php
function getValue(array $array, $key, $default = null)
{
    if (isset($array[$key])) {
        return $array[$key];
    }
    return $default;
}

function redirect($to)
 {
        header("Location: {$to}");
        die;
    }


 function requestPost($key, $default = null)
 {
       return getValue($_POST, $key, $default);
 }


 function requestGet($key, $default = null)
 {
        return getValue($_GET, $key, $default);
 }

function cookieSet($name, $value, $expire = 3600, $path = '/')
{
    setcookie($name, $value, time() + $expire, $path);
}

function cookieRemove($name)
{
    cookieSet($name, '', -1);
    unset($_COOKIE[$name]);
}

function cookieGet($name, $default = null)
{
    return getValue($_COOKIE, $name, $default);
}



function getSession($key, $default = null)
{
  return getValue($_SESSION, $key, $default);
}



function removeSession($key)
{
    if (isset($_SESSION[$key]) ) {
        unset($_SESSION[$key]);
    }
}