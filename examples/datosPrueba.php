<?php
function getIp()
    {
 
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            return $_SERVER["HTTP_FORWARDED"];
        }
        else
        {
            return $_SERVER["REMOTE_ADDR"];
        }
 
    }

$ipAddress = getIp();

$userAgent = $_SERVER['HTTP_USER_AGENT'];

$arrayPagador = [
    'document'     => '588999',
    'documentType' => 'CE',
    'firtsName'    => 'Pedro',
    'lastName'     => 'Perez',
    'emailAddress' => 'jcrojasv@gmail.com',
    'address'      => 'Cra. 80 #25-34',
    'city'         => 'Medellin',
    'province'     => 'Antioquia',
    'country'      => 'CO', 
    'phone'        => '2987370',
    'mobile'       => '300 555 55 55',
];

$arrayComprador = [
    'document'     => '1234567890',
    'documentType' => 'CC',
    'firtsName'    => 'John',
    'lastName'     => 'Jairo',
    'emailAddress' => 'jcrojasv@gmail.com',
    'address'      => 'Cra. 81 #25-34',
    'city'         => 'Medellin',
    'province'     => 'Antioquia',
    'country'      => 'CO', 
    'phone'        => '2987371',
    'mobile'       => '300 556 55 55',
];
