<?php
use Model\Model;

/** Autoloading The required Classes **/
class RegisterModel extends Model
{
    function __construct() {
        parent::__construct();
        $this->connect();
    }

    public function check_username_exists() : bool {
        return false;
    }
    public function check_email_exists() : bool {
        return false;
    }

    public function register_unverified_user() {

    }
    public function verify_user () {

    }
}
