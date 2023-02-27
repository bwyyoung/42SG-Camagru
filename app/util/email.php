<?php

namespace util;

use config\Config_str;
use const config\DEBUG_MODE;

class Email {
    //https://stackoverflow.com/questions/15965376/how-to-configure-xampp-to-send-mail-from-localhost

    public static function send_activation_email(string $username, string $useremail, string $activation_code) : bool
    {
        $link = Config_str::KW_DOMAIN->value.'/register/activate?email='.$useremail.'&activation_code='.$activation_code;
        // set email subject & body
        $subject = 'Camagru.sg: Please activate your account';
        $message = <<<MESSAGE
            Hi $username,
            
            Please click the following link to activate your account:
            $link
            
            Thanks fam,
            
            Camagru SG Team
            MESSAGE;
        // email header
        $header = "From:" . Config_str::SENDER_EMAIL_ADDRESS->value. "\r\n" .
            'Reply-To: '.Config_str::SENDER_EMAIL_ADDRESS->value. "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // send the email
        if (!mail($useremail, $subject, $message, $header)) {
            if (DEBUG_MODE)
                exit();
            return false;
        }
        return true;
    }
}