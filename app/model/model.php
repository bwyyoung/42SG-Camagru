<?php
namespace Model;

use PgSql\Connection;
use util\Debug;

class Model
{
    // DB Params
    private  $DB_HOST;
    private $DB_PORT;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASS;
    private $DB_SCHEMA;

    protected static Connection $db;

    function __construct() {
        $this->DB_HOST = getenv('DB_HOST');
        $this->DB_PORT = getenv('DB_PORT');
        $this->DB_NAME = getenv('DB_NAME');
        $this->DB_USER = getenv('DB_USER');
        $this->DB_PASS = getenv('DB_PASS');
        $this->DB_SCHEMA = getenv('DB_SCHEMA');

    }

    public function connect()
    {
        Model::$db = pg_connect($this->DB_HOST .' '.
            $this->DB_PORT.' '.
            $this->DB_NAME.' '.
            $this->DB_USER.' '.
            $this->DB_PASS);
        if(!Model::$db)
            Debug::console_log("Error : Unable to open database\n");
        else
            Debug::console_log("Opened database successfully\n");
    }
}