<?php
namespace Model\Table;
use config\Config_str;

class UserTable extends Table
{
    static $TABLENAME = 'users';

    static protected $attr_names = [
        Config_str::KW_USERNAME->value,
        Config_str::KW_EMAIL->value,
        Config_str::KW_PASSWORD->value,
        Config_str::KW_VERIFIED->value,
        Config_str::KW_RECEIVECOMMENTS->value
    ];

     static protected $attr_casts = [
        Config_str::KW_VERIFIED->value => 'bool',
        Config_str::KW_RECEIVECOMMENTS->value => 'bool',
    ];

     static protected $searchable = [
         Config_str::KW_USERNAME->value,
         Config_str::KW_EMAIL->value
     ];


}