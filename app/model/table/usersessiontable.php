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

    public function setcookie() {
        $lifetime = $this->rememberme ? (60 * 60 * 24 * 365) : (60 * 60);
        Debug::print_string('lifetime: '.$lifetime);
    }


}