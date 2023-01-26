<?php
include dirname(__FILE__) . '/../view/template/Template.php';

class IndexController {
    private $model;

    function __construct($tile) {
        $this->model = new $tile;
    }

    public function index() {
        Template::view('index.html');
    }

    public function login() {
        echo "Login Method";
    }

}