<?php

namespace util;

use config\Config_str;
use const config\DEBUG_MODE;

class Email {
    //https://stackoverflow.com/questions/15965376/how-to-configure-xampp-to-send-mail-from-localhost

    public static function send_activation_email(string $username, string $useremail, string $token) : bool
    {
        $link = Config_str::KW_DOMAIN->value.'/register/activate?email='.$useremail.'&token='.$token;
        // set email subject & body
        $subject = 'Camagru.sg: Please activate your account';
        $message = <<<MESSAGE
            Hi $username,
            
            Please click the following link to activate your account:
            $link
            
            Thanks fam,
            
            Camagru SG Team
            MESSAGE;
        return self::sendmail($useremail,$subject, $message);
    }
    public static function send_password_email(string $username, string $useremail, string $token) : bool
    {
        $link = Config_str::KW_DOMAIN->value.'/account/reset_password?email='.$useremail.'&token='.$token;
        // set email subject & body
        $subject = 'Camagru.sg: Reset Your Password';
        $message = <<<MESSAGE
            Hi $username,
            
            Please click the following link to reset your password:
            $link
            
            If you did not initiate this request for password reset, please ignore this email.
            
            Thanks fam,
            
            Camagru SG Team
            MESSAGE;
        return self::sendmail($useremail,$subject, $message);
    }

    private static function sendmail($useremail, $subject, $message) : bool {
        $header = "From:" . Config_str::SENDER_EMAIL_ADDRESS->value. "\r\n" .
            'Reply-To: '.Config_str::SENDER_EMAIL_ADDRESS->value. "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // send the email
        if (!mail($useremail, $subject, $message, $header)) {
            return false;
        }
        return true;
    }
}