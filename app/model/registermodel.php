<?php
namespace Model;
include_once 'table/usertable.php';

use Model\Table\UserTable;
use util\Security;
use util\Debug;

/** Autoloading The required Classes **/
class RegisterModel extends Model
{
    private UserTable $table_user;
    private $pepper;

    function __construct() {
        parent::__construct();
        $this->table_user = new UserTable();
        $this->pepper = getenv('WEBSITE_PEPPER');
    }

    //http://mysqltopgsql.com/post/sql-injection/
    public function check_credential_exists(string $id, string $value) : int {
        if (Security::attack_sql_injection($id) || Security::attack_sql_injection($value))
            return -1;
        if (!$this->table_user->key_searcheable($id))
            return -1;
        if (!$this->connect())
            return 0;
        $value = pg_escape_string($value);
        $r = pg_query_params(Model::$db, 'select '.$id.' from '.$this->DB_SCHEMA.'.'
            .$this->table_user->get_tablename().' where LOWER('.$id.') = LOWER(CAST($1 as TEXT))', array($value));
        return pg_num_rows($r) > 0;
    }

    public function verify_password($password, $confirmpassword): bool {
        if ($password !== $confirmpassword)
            return false;
        Debug::print_string('1 [a-z]');
        if (preg_match_all('/[a-z]/', $password) == 0)
            return false;
        Debug::print_string('2 [A-Z]');
        if (preg_match_all('/[A-Z]/', $password) == 0)
            return false;
        Debug::print_string('3 [0-9]');
        if (preg_match_all('/[0-9]/', $password) == 0)
            return false;
        Debug::print_string('4 \s');
        if (preg_match_all('/\s/', $password) > 0)
            return false;
        Debug::print_string('5 [#$%@^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]');
        if (preg_match_all('/[#$%@^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $password) == 0)
            return false;
        Debug::print_string('6 <8 >100');

        if (strlen($password) < 8)
            return false;
        if (strlen($password) > 100)
            return false;
        return true;
    }
    /*
     * register user as unverified. He canno
     */
    public function register_unverified_user($username, $email, $password) {
        //Salt is saved with password in this function.
        // Refer to https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html
        $hashed = password_hash($password.$this->pepper,
            PASSWORD_ARGON2ID,
            ['memory_cost' => 19456, 'time_cost' => 2, 'threads' => 1]);
        Debug::print_string($hashed);

    }

    /*
     * Set user as verified after email registration.
     */
    public function verify_user () {

    }

}
