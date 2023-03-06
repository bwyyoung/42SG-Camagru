<?php
namespace Model;


use config\Config_str;
use Model\Table\UserTable;
use util\Email;
use util\Security;

/** Autoloading The required Classes **/
class RegisterModel extends Model
{


    function __construct() {
        parent::__construct();
    }

    /*
     * register user as unverified. He canno
     */
    public function register_unverified_user($username, $email, $password) : bool{
        if (Security::attack_sql_injection($username) || Security::attack_sql_injection($email) || Security::attack_sql_injection($password))
            return false;
        //Salt is saved with password in this function.
        // Refer to https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html
        if (!$this->connect())
            return false;

        $hashed = Security::password_hash($password);
        $this->temp_user = new UserTable([
           Config_str::KW_USERNAME->value => $username,
            Config_str::KW_EMAIL->value => $email,
            Config_str::KW_PASSWORD->value => $hashed,
            Config_str::KW_VERIFIED->value => false,
            Config_str::KW_RECEIVECOMMENTS->value => true
        ]);
        return $this->temp_user->commit(static::$db);
    }



    public function send_verification_email() : bool {
        return Email::send_activation_email($this->temp_user->username, $this->temp_user->email, $this->temp_token->token());
    }

    /*
     * Set user as verified after email registration.
     */
    public function verify_user($user, $token) : bool {
        if (!$this->verify_token($user, $token, Config_str::KW_VERIFICATION->value))
            return false;
        $this->delete_token($user);
        $user->verified = true;
        $user->commit(static::$db);
        return true;
    }

}
