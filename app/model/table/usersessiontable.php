<?php

namespace Model\Table;

use Cassandra\Date;
use config\Config_str;
use Model\Model;
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
        $secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
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

    public function renew() {
        $this->issued = date('Y-m-d H:i:s');
        $this->commit(Model::get_db());
    }

    public static function get_session($sessionid) : ?UserSessionTable{
        $results = pg_select(Model::get_db(), self::get_schema().'.'.self::$TABLENAME,
            [
                Config_str::KW_SESSION->value => $sessionid
                ] );
        if (is_bool($results))
            return null;
        if (count($results) == 0)
            return null;
        $session = new UserSessionTable($results[0]);
        $issued = new \DateTime($session->issued);
        $earliest = new \DateTime();
        $earliest = $session->rememberme ? $earliest->modify('-1 year') : $earliest->modify('-1 hour');
        return ($issued >= $earliest ? $session : null);
    }


}