<?php
namespace Model;

use http\Exception;
use PgSql\Connection;
use util\Debug;

class Model
{
    protected static ?Connection $db = null;


    function __construct() {

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




}