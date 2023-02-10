<?php
use model\Model;
class Controller
{
    protected Model $model;

    function __construct($modelclass) {
        $this->model = $modelclass;
    }

}