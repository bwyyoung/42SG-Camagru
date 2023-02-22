<?php

namespace config;



//App Root
define("WEB_ROOT", dirname(dirname(__FILE__)));



const DEBUG_MODE = TRUE;

enum Config_str:string {
    case KW_ID = 'id';
    case KW_USERNAME = 'username';
    case KW_EMAIL = 'email';
    case KW_PASSWORD = 'password';
    case KW_VERIFIED = 'verified';
    case KW_RECEIVECOMMENTS = 'receivecomments';
    case KW_USER = 'user';
    case KW_SESSION = 'session';
    case KW_ISSUED = 'issued';
    case KW_REMEMBERME = 'rememberme';
    case KW_BOOL = 'bool';
    case KW_DATE = 'date';


    case URL_ROOT = '/';
    case URL_SUBFOLDER = '';
    case SITE_NAME = 'Camagru SG';
}

enum Config_flg:int {
    case DEBUG_MODE = 1;
    case PASSWD_LEN_MIN = 8;
    case PASSWD_LEN_MAX = 100;
}