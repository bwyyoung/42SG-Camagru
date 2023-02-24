<?php

namespace Model\Table;

use config\Config_str;

class LikeTable extends Table {
    static $TABLENAME = 'likes';

    static protected $attr_names = [
        Config_str::KW_USERSID->value,
        Config_str::KW_IMAGE->value,
        Config_str::KW_AT->value
    ];

    protected static $attr_casts = [
    ];
}