<?php

namespace config;



//App Root
define("WEB_ROOT", dirname(dirname(__FILE__)));



const DEBUG_MODE = TRUE;

enum Config_str:string {
    case KW_USERNAME = 'username';
    case KW_EMAIL = 'email';
    case KW_password = 'password';

    case URL_ROOT = '/';
    case URL_SUBFOLDER = '';
    case SITE_NAME = 'Camagru SG';
}

enum Config_flg:int {
    case DEBUG_MODE = 1;
}