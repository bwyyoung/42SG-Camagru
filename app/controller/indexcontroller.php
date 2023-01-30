<?php
include dirname(__FILE__) . '/../view/template/Template.php';

class IndexController {
    private $model;

    function __construct($tile) {
        $this->model = new $tile;
    }

    public function index() {
        Template::view('index.html', [
            'title' => 'Camagru SG (DSTA - Web Build 1)',
            'colors' => ['red','blue','green'],
            'username' => 'Terry',
            'age' => '11'
        ]);
    }

    public function login() {
        echo "Login Method";
    }

}