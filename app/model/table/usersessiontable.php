<?php

namespace Model\Table;

use config\Config_str;

class UserSessionTable extends Table
{
    static $TABLENAME = 'usersession';

    static protected $attr_names = [
        Config_str::KW_USER->value,
        Config_str::KW_SESSION->value,
        Config_str::KW_ISSUED->value,
        Config_str::KW_REMEMBERME->value
    ];

    protected static $attr_casts = [
        Config_str::KW_USER->value => UserTable::class,
        Config_str::KW_ISSUED->value => Config_str::KW_DATE->value,
        Config_str::KW_REMEMBERME->value => Config_str::KW_BOOL->value
    ];

    public function setcookie($request) {

    }


}