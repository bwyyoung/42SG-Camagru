<?php
namespace Model\Table;

use config\Config_flg;
use config\Config_str;
use PgSql\Result;
use PSpell\Config;
use util\Debug;

Class Table {
    static  $TABLENAME = 'Table';
    protected $SCHEMA;
    protected $attr;
    protected $dirty_keys = [];
    protected int $id;

    protected static $attr_default_values = [];
    protected static $attr_casts = [];
    protected static $attr_names = [];
    protected static $searchable =[];


    public function get_schema():string {
        return $this->SCHEMA;
    }
    public function get_tablename():string {
        return static::$TABLENAME;
    }
    function key_searcheable($key): bool {
        return in_array($key, static::$searchable);
    }

    function __construct(array $attrs = []) {

        $this->SCHEMA = getenv('DB_SCHEMA');
        $this->init_table_field();
        $this->init_table_attr($attrs);
    }

    function init_table_field() {
        $this->attr = array_fill_keys(static::$attr_names, null);
        $this->id = Config_flg::ID_NULL->value;
    }

    function init_table_attr(array $attr) {
        $this->attr = [];
        foreach ($attr as $k => $v)
            if (in_array($k, static::$attr_names))
                $this->__set($k, $v);
            else
                throw new \Exception('Invalid Key '.$k.' in Model '.get_class($this));
        $this->dirty_keys = [];
    }

    public function __set($key, $value) {
        if ($key != Config_str::KW_ID->value)
            if (!in_array($key, static::$attr_names))
                throw new \Exception('Invalid Key Set '.$key.' in Model '.get_class($this));;
        if (array_key_exists($key, static::$attr_casts))
            switch (static::$attr_casts[$key]) {
                case 'bool':
                    $value = (int)$value;
                    break;
                case 'date':
                    if (strtotime($value) <= strtotime(0))
                        $value = date('Y-m-d H:i:s');
                    break;
                case 'id':
                    $value = (int) $value;
            }
        if (array_key_exists($key, $this->attr))
                if ($this->attr[$key] != $value)
                    $this->dirty_keys[$key] = $value;
        $this->attr[$key] = $value;
    }

    public function id() {
        return $this->id;
    }

    public function __get(string $key) {
        if (in_array($key, $this->attr))
            return $this->attr[$key];
        return null;
    }

    /*
       * commit the fields in this model to the respective database.
       */
    public function commit($db): bool {
        if ($this->id == Config_flg::ID_NULL->value) {
            $values = '$' . implode(',$', range(1, count($this->attr)));

            $query = 'INSERT INTO '.$this->SCHEMA.'.'.static::$TABLENAME.
                '('.implode(',', static::$attr_names). ')'.
                ' VALUES('.$values.') RETURNING '.Config_str::KW_ID->value;
            Debug::print_string($query);
            var_dump($this->attr);
            $result =  pg_query_params($db,$query, $this->attr);

            if (is_bool($result))
                return false;
            $result= pg_fetch_result($result, 0 ,0);
            if (is_bool($result))
                return false;
            $this->id = (int)$result;
            Debug::print_string('result: '. $result);
            Debug::print_string('id: '.$this->id);
            return true;
        }
        if (count($this->dirty_keys) == 0)
            return true;
        $result = pg_update($db, $this->SCHEMA.'.'.static::$TABLENAME,
        $this->dirty_keys, [Config_str::KW_ID->value => $this->id]);
        if ($result)
            $this->dirty_keys = [];
        return $result;
    }
}