<?php

namespace Model\Table;

use config\Config_str;

class CommentTable extends Table {
    static $TABLENAME = 'comments';

    static protected $attr_names = [
        Config_str::KW_USERSID->value,
        Config_str::KW_IMAGE->value,
        Config_str::KW_USERSID->value,
        Config_str::KW_MESSAGE->value,
        Config_str::KW_AT->value
    ];

    protected static $attr_casts = [
    ];
}