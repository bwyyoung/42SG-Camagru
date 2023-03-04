<?php

namespace core;

include_once WEB_ROOT.'/app/util/dotenv.php';
include_once WEB_ROOT.'/app/util/security.php';
include_once WEB_ROOT.'/app/util/debug.php';
include_once WEB_ROOT.'/app/util/email.php';
include_once WEB_ROOT.'/app/model/model.php';
include_once WEB_ROOT.'/app/model/table/table.php';
include_once WEB_ROOT.'/app/model/table/usertable.php';
include_once WEB_ROOT.'/app/model/table/usersessiontable.php';
include_once WEB_ROOT.'/app/controller/controller.php';
include_once WEB_ROOT.'/app/view/template/Template.php';

use util\Debug;
use util\DotEnv;

class Init
{
    public $req_param = '';
    public $req_method = '';
    public $req_controller = '';
    public $req_model = '';

    public bool $login = false;

    private static $instances = [];
    /**
     * The Singleton's constructor should always be private to prevent direct
     * construction calls with the `new` operator.
     */
    protected function __construct() {
        $this->setup();
    }

    public function reset_camagru() {

    }
    private function setup_env() {
        $dotenv = new DotEnv(WEB_ROOT.'/.env');
        $dotenv->load();
    }
    private function setup() {
        $this->setup_env();
    }

    /**
     * Singletons should not be cloneable.
     */
    protected function __clone() { }

    /**
     * Singletons should not be restorable from strings.
     */
    public function __wakeup()
    {
        throw new \Exception('Cannot unserialize a singleton.');
    }

    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     *
     * This implementation lets you subclass the Singleton class while keeping
     * just one instance of each subclass around.
     */
    public static function getInstance(): Init
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }
        return self::$instances[$cls];
    }
}