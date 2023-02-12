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

    public function check_credential_exists(string $id, string $value) : bool {
        if (!$this->connect())
            return false;
        $r = pg_query_params(Model::$db, 'select '.$id.' from camagru_glagan.users 
                where '.$id.' ~* $1', array($value));
        return pg_num_rows($r) > 0;
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
