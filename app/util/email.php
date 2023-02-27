<?php

namespace util;

use config\Config_str;
use const config\DEBUG_MODE;

class Email {
    public static function send_activation_email(string $useremail, string $activation_code) : bool
    {
        $link = Config_str::KW_DOMAIN->value.'/register/activate?email=$email&activation_code=$activation_code';
        // set email subject & body
        $subject = 'Please activate your account';
        $message = <<<MESSAGE
            Hi,
            Please click the following link to activate your account:
            $activation_code
            MESSAGE;
        // email header
        $header = "From:" . Config_str::SENDER_EMAIL_ADDRESS->value;

        // send the email
        if (!mail($useremail, $subject, nl2br($message), $header)) {
            if (DEBUG_MODE)
                exit();
            return false;
        }
        return true;
    }
}