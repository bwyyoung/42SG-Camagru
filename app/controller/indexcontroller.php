<?php
include dirname(__FILE__) . '/../view/template/Template.php';

class IndexController {
    private $model;

    function __construct($modelclass) {
        $this->model = new $modelclass;
    }

    public function index() {
        Template::view('index.html', [
            'title' => 'Camagru SG Home Page'
        ]);
    }

    public function about() {
        Template::view('index.html', [
            'title' => 'Camagru SG - About'
        ]);
    }

    public function contact() {
        Template::view('index.html', [
            'title' => 'Camagru SG - Contact'
        ]);
    }

    public function login() {
        echo "Login Method";
    }
}