<?php

class IndexController {
    private $model;

    function __construct($tile) {
        $this->model = new $tile;
    }

    public function index() {
        return "Index Method";
    }

    public function login() {
        echo "Login Method";
    }

}