<?php
namespace Model;
include_once 'table/usertable.php';
include_once 'table/usersessiontable.php';
include_once 'table/usertokentable.php';

use config\Config_str;
use Couchbase\User;
use Model\Table\UserSessionTable;
use Model\Table\UserTable;
use Model\Table\UserTokenTable;
use util\Email;
use util\Security;
use util\Debug;

/** Autoloading The required Classes **/
class RegisterModel extends Model
{
    private UserTable $table_user;
    private $table_records;
    private UserSessionTable $table_session;
    private UserTokenTable $table_token;
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
        if (!is_bool($records))
            $this->table_records = $records;
        return (!($records == false) && count($records) > 0);
    }

    public function set_current_user($id, $value) : bool{
        if (!$this->check_credential_exists($id, $value))
            return false;
        $this->table_user = new UserTable($this->table_records[0]);
        return true;
    }

    public function get_user():UserTable {
        return $this->table_user;
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
        if (!$this->connect())
            return false;

        $hashed = password_hash($password.$this->pepper,
            PASSWORD_ARGON2ID,
            ['memory_cost' => 19456, 'time_cost' => 2, 'threads' => 1]);
        $this->table_user = new UserTable([
           Config_str::KW_USERNAME->value => $username,
            Config_str::KW_EMAIL->value => $email,
            Config_str::KW_PASSWORD->value => $hashed,
            Config_str::KW_VERIFIED->value => false,
            Config_str::KW_RECEIVECOMMENTS->value => true
        ]);
        return $this->table_user->commit(static::$db);
    }



    public function create_new_session() : bool {
        // Register a new valid session
        Debug::print_string('Session ID '.session_id());

        pg_delete(static::$db, $this->table_user->get_schema().'.'.UserSessionTable::$TABLENAME,
            [Config_str::KW_USERSID->value => $this->table_user->id()]);

        $this->table_session = new UserSessionTable([
            Config_str::KW_USERSID->value => $this->table_user->id(),
            Config_str::KW_SESSION->value => session_id(),
            Config_str::KW_ISSUED->value => date('Y-m-d H:i:s'),
            Config_str::KW_REMEMBERME->value => false
        ]);
        if (!$this->table_session->commit(static::$db))
            return false;
        return $this->table_session->setcookie($this->table_session->rememberme);
    }

    public function generate_token(): bool {
        pg_delete(static::$db, $this->table_user->get_schema().'.'.UserTokenTable::$TABLENAME,
            [Config_str::KW_USERSID->value => $this->table_user->id()]);
        $this->table_token = new UserTokenTable([
            Config_str::KW_USERSID->value => $this->table_user->id(),
            Config_str::KW_SCOPE->value =>  Config_str::KW_VERIFICATION->value
        ]);
        $this->table_token->generate_token();
        return $this->table_token->commit(static::$db);
    }

    public function send_verification_email() : bool {
        return Email::send_activation_email($this->table_user->username, $this->table_user->email, $this->table_token->token());
    }

    /*
     * Set user as verified after email registration.
     */
    public function check_token($token) : bool {
        if (Security::attack_sql_injection($token))
            return false;
        $records = pg_select(static::$db, $this->table_user->get_schema().'.'.UserTokenTable::$TABLENAME, [Config_str::KW_USERSID->value => $this->table_user->id()]);
        if (is_bool($records))
            return false;
        if (count($records) == 0)
            return false;
        $this->table_token = new UserTokenTable($records[0]);
        if ($this->table_token->token != $token)
            return false;
        pg_delete(static::$db, $this->table_user->get_schema().'.'.UserTokenTable::$TABLENAME, [Config_str::KW_USERSID->value => $this->table_user->id()]);
        $now = new \DateTime();
        $tokentime= new \DateTime($this->table_token->issued);
        Debug::print_string($tokentime->format(DATE_RFC2822));
        if ($now->diff($tokentime, true)->days > 1)
            return false;
        $this->table_user->verified = true;
        $this->table_user->commit(static::$db);
        return true;
    }

}
