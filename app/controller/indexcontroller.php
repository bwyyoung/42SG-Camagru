<?php

namespace Controller;
use core\Init as Init;
use util\Debug;
use View\Template as Template;

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