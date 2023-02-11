<?php
use Model\Model;
use PgSql\Result as Result;

/** Autoloading The required Classes **/
class RegisterModel extends Model
{
    function __construct() {
        parent::__construct();
        $this->connect();
    }

    public function check_username_exists(string $username) : bool {

        $r = pg_query_params(Model::$db, 'select username from camagru_glagan.users 
                where username ~*  quote_ident(CAST($1 AS text))', array($username));
        return pg_num_rows($r) > 0;
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
