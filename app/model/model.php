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

    private Connection $db;

    function __construct() {
        $this->DB_HOST = getenv('DB_HOST');
        $this->DB_PORT = getenv('DB_PORT');
        $this->DB_NAME = getenv('DB_NAME');
        $this->DB_USER = getenv('DB_USER');
        $this->DB_PASS = getenv('DB_PASS');
    }

    public function connect()
    {
        $this->db = pg_connect($this->DB_HOST .' '.
            $this->DB_PORT.' '.
            $this->DB_NAME.' '.
            $this->DB_USER.' '.
            $this->DB_PASS);
        if(!$this->db)
            Debug::print_string("Error : Unable to open database\n");
        else
            Debug::print_string("Opened database successfully\n");
    }
}