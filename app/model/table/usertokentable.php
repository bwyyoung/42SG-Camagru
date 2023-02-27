<?php

namespace Model\Table;

use config\Config_str;
use util\Debug;
class UserTokenTable extends Table {
    static $TABLENAME = 'usertokens';

    static protected $attr_names = [
        Config_str::KW_USERSID->value,
        Config_str::KW_TOKEN->value,
        Config_str::KW_SCOPE->value,
        Config_str::KW_ISSUED->value
    ];

    public function generate_token() {
        $this->token = bin2hex(random_bytes(25));
        $this->issued = date('Y-m-d H:i:s');
    }

    protected static $attr_casts = [
        'issued' => 'date'
    ];

    public function token(): string
    {
        return $this->token;
    }

}