<?php

namespace config;

const DEBUG_MODE = FALSE;

enum Config_str:string {
    case KW_ID = 'id';
    case KW_USERNAME = 'username';
    case KW_EMAIL = 'email';
    case KW_PASSWORD = 'password';
    case KW_VERIFIED = 'verified';
    case KW_RECEIVECOMMENTS = 'receivecomments';
    case KW_USERSID = 'usersid';
    case KW_SESSION = 'session';
    case KW_VALUE = 'value';
    case KW_ISSUED = 'issued';
    case KW_REMEMBERME = 'rememberme';
    case KW_BOOL = 'bool';
    case KW_DATE = 'date';
    case KW_TOKEN = 'token';
    case KW_SCOPE = 'scope';
    case KW_AT = 'at';
    case KW_CREATION = 'creation';
    case KW_NAME = 'name';
    case KW_ANIMATED = 'animated';
    case KW_PUBLIC = 'public';
    case KW_MESSAGE = 'message';
    case KW_IMAGE = 'image';
    case KW_POSITION ='position';
    case KW_VERIFICATION = 'verification';

    case KW_DOMAIN = 'camagru.sg';

    case KW_STATE = 'state';
    case KW_TITLE = 'title';
    case STATE_RESEND_VERIFICATION_EMAIL = 'state_resend_verification_email';
    case STATE_ERROR = 'state_error';
    case STATE_DEFAULT = 'state_default';
    case STATE_REGISTRATION = 'state_registration';
    case STATE_REGISTERED = 'state_registered';
    case STATE_ACTIVATED = 'state_activated';

    case STATE_PROFILE = 'state_profile';
    case STATE_SETTINGS = 'state_settings';
    case STATE_FORGOTPASSWORD = 'state_forgotpassword';
    case STATE_FORGOTPASSWORD_SUBMIT = 'state_forgotpassword_submit';
    case STATE_RESETPASSWORD = 'state_resetpassword';
    case STATE_UPLOAD = 'state_upload';

    case SENDER_EMAIL_ADDRESS = 'noreply@camagru.sg';

    case URL_ROOT = '/';
    case URL_SUBFOLDER = '';
    case SITE_NAME = 'Camagru SG';
}

enum Config_error:int {
    case OK = 0;
}

enum Config_flg:int {
    case DEBUG_MODE = 1;
    case ID_NULL = -1;
    case PASSWD_LEN_MIN = 8;
    case PASSWD_LEN_MAX = 100;
}