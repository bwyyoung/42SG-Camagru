<?php
include dirname(__FILE__) . '/../view/template/Template.php';
use core\Init as Init;
use util\Debug as Debug;
class RegisterController
{
    private $model;

    function __construct($modelclass)
    {
        $this->model = new $modelclass;
    }

    public function index()
    {
        if (Init::getInstance()->login)
        {
            header("Location: http://camagru.sg");
            exit();
        }
        Template::view('register.html', [
            'title' => 'Camagru SG Registration',
        ]);
    }

    public function register_account() {
        if (Init::getInstance()->login)
        {
            header("Location: http://camagru.sg");
            exit();
        }
        echo "Register button";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            Debug::print_string($_POST['username']);
            Debug::print_string($_POST['email']);
            Debug::print_string($_POST['psw']);
        }
    }
}



