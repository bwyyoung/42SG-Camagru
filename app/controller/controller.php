<?php
use model\Model;
class Controller
{
    protected $model;

    function __construct(Model $model) {
        $this->model = $model;
    }

}