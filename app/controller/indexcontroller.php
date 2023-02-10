<?php
include dirname(__FILE__) . '/../view/template/Template.php';

class IndexController extends Controller {

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