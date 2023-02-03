<?php
include dirname(__FILE__) . '/../view/template/Template.php';

class RegisterController
{
    private $model;

    function __construct($modelclass)
    {
        $this->model = new $modelclass;
    }

    public function index()
    {
        Template::view('register.html', [
            'title' => 'Camagru SG Registration',
        ]);
    }
}



