<?php

namespace util;

use config\Config_str;

class Email {
    public static function send_activation_email(string $useremail, string $activation_code)
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
        mail($useremail, $subject, nl2br($message), $header);
    }
}