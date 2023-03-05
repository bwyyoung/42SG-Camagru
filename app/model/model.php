<?php
namespace Model;

use config\Config_str;
use core\Init;
use http\Exception;
use Model\Table\UserSessionTable;
use Model\Table\UserTable;
use Model\Table\UserTokenTable;
use PgSql\Connection;
use PSpell\Config;
use util\Debug;
use util\Security;

class Model
{
    protected static ?Connection $db = null;
    protected static ?UserTable $USER_DATA = null;
    protected UserTable $temp_user;
    protected UserSessionTable $temp_session;
    protected $temp_records;
    protected UserTokenTable $temp_token;

    function __construct() {
        self::$USER_DATA = null;
        $this->temp_user = new UserTable();
        $this->retrieve_session();
        Init::getInstance()->login = true;
        if (self::$USER_DATA === null)
            Init::getInstance()->login = false;
    }

    public static function connect() : bool
    {
        Model::$db = pg_connect(getenv('DB_HOST') .' '.
            getenv('DB_PORT').' '.
            getenv('DB_NAME').' '.
            getenv('DB_USER').' '.
            getenv('DB_PASS'));
        if(!Model::$db) {
            Debug::print_string("Error : Unable to open database\n");
           return false;
        }
        return true;
    }

    public function get_userdata() : ?UserTable {
        return self::$USER_DATA;
    }
    public static function get_username() : string {
        if (self::$USER_DATA != null)
            return self::$USER_DATA->username;
        return '';
    }


    public static function get_db() {
        if (Model::$db === null)
            self::connect();
        return Model::$db;
    }

    protected function retrieve_session() {
        $session = UserSessionTable::get_session(session_id());
        if ($session === null)
            return;
        $session->renew();
        self::$USER_DATA = UserTable::gettable_id($session->usersid);
    }

    //http://mysqltopgsql.com/post/sql-injection/
    public function check_credential_exists(string $id, string $value) : int {
        if (Security::attack_sql_injection($id) || Security::attack_sql_injection($value))
            return -1;
        if (!$this->temp_user->key_searcheable($id))
            return -1;
        if (!$this->connect())
            return 0;
        $value = pg_escape_string($value);

        // TODO: Change to prepared statements?
        $records = pg_select(static::$db, $this->temp_user->get_schema().'.'.$this->temp_user::$TABLENAME, [$id => $value]);
        $this->temp_records = !(is_bool($records)) ? $records : null;
        return (!($records == false) && count($records) > 0);
    }

    public function set_temp_user($id, $value) : bool{
        if (!$this->check_credential_exists($id, $value))
            return false;
        $this->temp_user = new UserTable($this->temp_records[0]);
        return true;
    }

    public function get_temp_user():UserTable {
        return $this->temp_user;
    }

    public function generate_token($scope): bool {
        pg_delete(static::$db, $this->temp_user->get_schema().'.'.UserTokenTable::$TABLENAME,
            [Config_str::KW_USERSID->value => $this->temp_user->id()]);
        $this->temp_token = new UserTokenTable([
            Config_str::KW_USERSID->value => $this->temp_user->id(),
            Config_str::KW_SCOPE->value => $scope
        ]);
        $this->temp_token->generate_token();
        return $this->temp_token->commit(static::$db);
    }

    protected function verify_token($token, $scope) : bool {
        $records = pg_select(static::$db, $this->temp_user->get_schema().'.'.UserTokenTable::$TABLENAME, [Config_str::KW_USERSID->value => $this->temp_user->id()]);
        if (is_bool($records))
            return false;
        if (count($records) == 0)
            return false;
        $this->temp_token = new UserTokenTable($records[0]);
        if ($this->temp_token->token != $token)
            return false;
        if ($this->temp_token->scope != $scope)
            return false;
        pg_delete(static::$db, $this->temp_user->get_schema().'.'.UserTokenTable::$TABLENAME, [Config_str::KW_USERSID->value => $this->temp_user->id()]);
        $now = new \DateTime();
        $tokentime= new \DateTime($this->temp_token->issued);
        return  !($now->diff($tokentime, true)->days > 1);
    }
}