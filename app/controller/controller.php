<?php
namespace Controller;
use model\Model;
use Model\Table\UserSessionTable;
use Model\Table\UserTable;
use util\Debug;

class Controller
{

    protected $model;

    function __construct(Model $model) {
        $this->model = $model;
    }

}