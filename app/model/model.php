<?php
namespace Model;

use core\Init;
use http\Exception;
use Model\Table\UserSessionTable;
use Model\Table\UserTable;
use PgSql\Connection;
use util\Debug;

class Model
{
    protected static ?Connection $db = null;
    protected static ?UserTable $USER_DATA = null;


    function __construct() {
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

    public function login(): bool {
        return true;
    }

    public function logout(): bool {
        return true;
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

}