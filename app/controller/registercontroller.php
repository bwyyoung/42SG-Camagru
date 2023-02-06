<?php
include dirname(__FILE__) . '/../view/template/Template.php';
use core\Init as Init;
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
    }
}



