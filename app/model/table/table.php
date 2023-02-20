<?php
namespace Model\Table;

Class Table {
    static protected $TABLENAME;
    protected $attr;
    protected $dirty_keys;

    protected static $attr_default_values = [];
    protected static $attr_casts = [];
    protected static $attr_names = [];
    protected static $searchable =[];


    public function get_tablename():string {
        return static::$TABLENAME;
    }

    function key_searcheable($key): bool {
        return in_array($key, static::$searchable);
    }

    function __construct(array $attrs = []) {
        $this->init_model_field();
        $this->init_model_attr($attrs);
    }

    function init_model_field() {
        $this->attr = array_fill_keys(static::$attr_names, null);
    }

    function init_model_attr(array $attr) {
        $this->attr = [];
        foreach ($attr as $k => $v)
            if (in_array($k, static::$attr_names))
                $this->attr_set($k, $v);
            else
                throw new \Exception('Invalid Key '.$k.' in Model '.get_class($this));
        $this->dirty_keys = [];
    }

    public function attr_set(string $key, string $value) {
        if (!in_array($key, static::$attr_names))
            throw new \Exception('Invalid Key Set '.$key.' in Model '.get_class($this));;
        if (isset($key, static::$attr_casts))
            switch ($key) {
                case 'bool':
                    $value = !!$value;
                    break;
                case 'date':
                    if (!($value instanceof \DateTime))
                        $value = new \DateTime($value);
                    break;
                case 'id':
                    $value = (int) $value;
            }
        if (!in_array($key, $this->dirty_keys))
            if ($this->attr[$key] != $value)
                $this->dirty_keys = $key;
        $this->attr[$key] = $value;
    }

    public function attr_get(string $key) {

    }


}