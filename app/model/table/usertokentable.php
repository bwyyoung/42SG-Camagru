<?php

namespace Model\Table;

use config\Config_str;

class UserTokenTable extends Table {
    static $TABLENAME = 'usertokens';

    static protected $attr_names = [
        Config_str::KW_USERSID->value,
        Config_str::KW_TOKEN->value,
        Config_str::KW_SCOPE->value,
        Config_str::KW_ISSUED->value
    ];

    protected static $attr_casts = [

        ];

}