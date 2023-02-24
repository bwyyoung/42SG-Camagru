<?php

namespace Model\Table;

use config\Config_str;

class DecorationTable extends Table {
    static $TABLENAME = 'decorations';

    static protected $attr_names = [
        Config_str::KW_NAME->value,
        Config_str::KW_ANIMATED->value,
        Config_str::KW_PUBLIC->value,
        Config_str::KW_POSITION->value
    ];

    protected static $attr_casts = [
    ];
}