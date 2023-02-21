<?php
namespace Model;
include_once 'table/usertable.php';

use config\Config_str;
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

        // TODO: Change to prepared statements?
        $records = pg_select(static::$db, $this->table_user->get_schema().'.'.$this->table_user::$TABLENAME, [$id => $value]);
        return (!($records == false) && count($records) > 0);
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
    public function register_unverified_user($username, $email, $password) : bool{
        if (Security::attack_sql_injection($username) || Security::attack_sql_injection($email) || Security::attack_sql_injection($password))
            return false;
        //Salt is saved with password in this function.
        // Refer to https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html
        $hashed = password_hash($password.$this->pepper,
            PASSWORD_ARGON2ID,
            ['memory_cost' => 19456, 'time_cost' => 2, 'threads' => 1]);
        $user = new UserTable([
           Config_str::KW_USERNAME->value => $username,
            Config_str::KW_EMAIL->value => $email,
            Config_str::KW_PASSWORD->value => $hashed,
            Config_str::KW_VERIFIED->value => 0,
            Config_str::KW_RECEIVECOMMENTS->value => 1
        ]);
        if (!$this->connect())
            return false;
        if (!$user->commit(static::$db))
            return false;

        return true;
    }

    /*
     * Set user as verified after email registration.
     */
    public function verify_user () {

    }

}
