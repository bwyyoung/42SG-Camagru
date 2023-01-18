<?php

include "../app/util/debug.php";
use util\Debug as Debug;

include "../app/core/init.php";
use core\Init as Init;

Debug::print_string("\$_SERVER['REQUEST_URI']: ".$_SERVER['REQUEST_URI']);
Debug::print_string("\$_SERVER['PATH_INFO']: ".($_SERVER['PATH_INFO'] ?? 'undefined'));


$path = $_SERVER['REQUEST_URI'];

if (isset($req_method))
    $method = $req_method; // Loaded from CORE, come back later.

if ($path === '/')
{
    require_once WEB_ROOT.'/app/model/indexmodel.php';
    require_once WEB_ROOT.'/app/controller/indexcontroller.php';
    $req_model = new IndexModel();
    $req_controller = new IndexController($req_model);

    $model = $req_model;
    $controller = $req_controller;

    $obj_model = new $model;
    $obj_controller = new $controller($model);

    if (Init::getInstance()->req_method == '')
        return print $obj_controller->index();
    return print $obj_controller->$method(Init::getInstance()->req_param);
}

$path_split = explode('/', ltrim($path));
Debug::print_string("The request path is : ".print_r($path_split, true));
$req_model = $req_controller = $path_split[1];
Debug::print_string($req_model."   |    ".$req_controller);
Init::getInstance()->req_param = array_slice($path_split, 3);
$req_controller_exists = WEB_ROOT.'/app/controller/'.$req_controller.'Controller.php';

if (!file_exists($req_controller_exists))
{
    header('HTTP/1.1 404 Not Found');
    die('404 - The file - '.$req_controller.' - not found');
}

require_once WEB_ROOT.'/app/model/'.$req_model.'model.php';
require_once WEB_ROOT.'/app/controller/'.$req_controller.'controller.php';
$model = ucfirst($req_model).'Model';
$controller = ucfirst($req_controller).'Controller';
$obj_model = new $model;
$obj_controller = new $controller($model);
$req_method = $path_split[2] ?? '';
if ($req_method == '')
    return print $obj_controller->index();
print $obj_controller->$method(Init::getInstance()->req_param);