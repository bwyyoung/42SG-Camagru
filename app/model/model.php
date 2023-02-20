<?php
namespace Model;

use http\Exception;
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
    protected $DB_SCHEMA;




    protected static Connection $db;

    function init_db_credentials() {
        $this->DB_HOST = getenv('DB_HOST');
        $this->DB_PORT = getenv('DB_PORT');
        $this->DB_NAME = getenv('DB_NAME');
        $this->DB_USER = getenv('DB_USER');
        $this->DB_PASS = getenv('DB_PASS');
        $this->DB_SCHEMA = getenv('DB_SCHEMA');
    }
    function __construct() {
        $this->init_db_credentials();
    }

    public function connect() : bool
    {
        Model::$db = pg_connect($this->DB_HOST .' '.
            $this->DB_PORT.' '.
            $this->DB_NAME.' '.
            $this->DB_USER.' '.
            $this->DB_PASS);
        if(!Model::$db) {
            Debug::print_string("Error : Unable to open database\n");
           return false;
        }
        return true;
    }

    /*
     * commit the fields in this model to the respective database.
     */
    public function commit(): bool {

    }
}