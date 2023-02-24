<?php

namespace Model\Table;

use config\Config_str;

class CreationTable extends Table {
    static $TABLENAME = 'creations';

    static protected $attr_names = [
        Config_str::KW_USERSID->value,
        Config_str::KW_NAME->value,
        Config_str::KW_ANIMATED->value,
        Config_str::KW_AT->value
    ];

    protected static $attr_casts = [
    ];
}