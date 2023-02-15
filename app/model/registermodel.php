<?php
use Model\Model;
use util\Security;
use util\Debug;

/** Autoloading The required Classes **/
class RegisterModel extends Model
{
    function __construct() {
        parent::__construct();
    }

    //http://mysqltopgsql.com/post/sql-injection/
    public function check_credential_exists(string $id, string $value) : int {
        if (Security::attack_sql_injection($id) || Security::attack_sql_injection($value))
            return -1;
        if (!$this->connect())
            return 0;
        $value = pg_escape_string($value);
        $r = pg_query_params(Model::$db, 'select '.$id.' from camagru_glagan.users 
                where LOWER('.$id.') = LOWER(CAST($1 as TEXT))', array($value));
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
