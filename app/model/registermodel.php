<?php
use Model\Model;

/** Autoloading The required Classes **/
class RegisterModel extends Model
{
    function __construct() {
        parent::__construct();
    }

    public function check_username_exists(string $username) : bool {

        return false;
    }
    public function check_email_exists(string $email) : bool {
        return false;
    }

    /*
     * register user as unverified. He canno
     */
    public function register_unverified_user() {

    }

    /*
     * Set user as verified after email registration.
     */
    public function verify_user () {

    }

}
