<?php
namespace Model;

use PgSql\Connection;
use util\Debug;
use util\Security as Security;
class Model
{
    // DB Params
    private  $DB_HOST;
    private $DB_PORT;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASS;
    private $DB_SCHEMA;

    protected static $db_fields = [];
    protected static $db_field_defaults = [];
    protected static $db_field_casts = [];

    protected $db_dirty;
    protected $db_column_names;

    protected static Connection $db;

    function init_db_params() {
        $this->DB_HOST = getenv('DB_HOST');
        $this->DB_PORT = getenv('DB_PORT');
        $this->DB_NAME = getenv('DB_NAME');
        $this->DB_USER = getenv('DB_USER');
        $this->DB_PASS = getenv('DB_PASS');
        $this->DB_SCHEMA = getenv('DB_SCHEMA');
    }

    function init_model_fields(array $fields) {
        static::$db_fields = [];
        foreach ($fields as $k => $v) {
            $this->field_set($k, $v);
        }
        $this->db_dirty = [];
    }

    public function field_set(string $key, string $value) {
        if (isset($key, $this->db_field_casts))
            switch ($key) {
                case 'bool':
                    $value = !!$value;
                    break;
                case 'date':
                    if (!($value instanceof \DateTime))
                        $value = new \DateTime($value);
                    break;
            }


    }

    function __construct(array $fields = []) {
        $this->init_db_params();
        $this->init_model_fields($fields);
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