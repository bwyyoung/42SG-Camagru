<?php

namespace Model\Table;

use config\Config_str;
use util\Debug;

class UserSessionTable extends Table
{
    static $TABLENAME = 'usersessions';

    static protected $attr_names = [
        Config_str::KW_USERSID->value,
        Config_str::KW_SESSION->value,
        Config_str::KW_ISSUED->value,
        Config_str::KW_REMEMBERME->value
    ];

    protected static $attr_casts = [
        Config_str::KW_USERSID->value => UserTable::class,
        Config_str::KW_ISSUED->value => Config_str::KW_DATE->value,
        Config_str::KW_REMEMBERME->value => Config_str::KW_BOOL->value
    ];

    public static function setcookie($rememberme) : bool {

        $lifetime = $rememberme ? (60 * 60 * 24 * 365) : (60 * 60);
        $cookiedomain =  (\strpos($_SERVER['HTTP_HOST'], 'localhost') === false) ? $_SERVER['HTTP_HOST'] : false;
        $secure =
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443;
        $result = setcookie('session', session_id(), [
            'expires' => time() + $lifetime,
            'path' => '/',
            'domain' => $cookiedomain,
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Strict',
        ]);
        return $result;
    }


}