<?php
session_start();

include "../app/util/security.php";
include "../app/util/debug.php";
include "../app/model/model.php";
include "../app/controller/controller.php";

use util\Debug as Debug;
include  "../app/core/init.php";
use core\Init as Init;

Init::getInstance()->login = !(!isset($_SESSION['login']) || $_SESSION['login'] == NULL || !($_SESSION['login']));

Debug::print_string("\$_SERVER['REQUEST_URI']: ".$_SERVER['REQUEST_URI']);
Debug::print_string("\$_SERVER['PATH_INFO']: ".($_SERVER['PATH_INFO'] ?? 'undefined'));
#Debug::print_string(getenv('WEBSITE_PEPPER'));

$path = $_SERVER['REQUEST_URI'];

$path_split = explode('/', ltrim($path));
Debug::print_string("The request path is : ".print_r($path_split, true));
Init::getInstance()->req_model = Init::getInstance()->req_controller = $path_split[1];
if ($path === '/')
    Init::getInstance()->req_model = Init::getInstance()->req_controller = 'index';

Init::getInstance()->req_param = array_slice($path_split, 3);
$req_controller_exists = WEB_ROOT.'/app/controller/'.Init::getInstance()->req_controller.'controller.php';

if (!file_exists($req_controller_exists))
{
    header('HTTP/1.1 404 Not Found');
    die('404 - The file - '.Init::getInstance()->req_controller.' - not found');
}

include WEB_ROOT.'/app/model/'.Init::getInstance()->req_model.'model.php';
include WEB_ROOT.'/app/controller/'.Init::getInstance()->req_controller.'controller.php';
$model = ucfirst(Init::getInstance()->req_model).'Model';
$controller = ucfirst(Init::getInstance()->req_controller).'Controller';
$obj_controller = new $controller(new $model);

// Methods come after the req_model.
Init::getInstance()->req_method = $path_split[2] ?? '';

if (Init::getInstance()->req_method == '')
    return $obj_controller->index();
if (method_exists($obj_controller, Init::getInstance()->req_method))
    return $obj_controller->{Init::getInstance()->req_method}(Init::getInstance()->req_param);

header('HTTP/1.1 404 Not Found');
die('404 - The method - '.Init::getInstance()->req_method.' - not found');