<?php



include "../app/util/security.php";
include "../app/util/debug.php";
include "../app/util/email.php";
include "../app/model/model.php";
include "../app/model/table/table.php";
include "../app/model/table/usersessiontable.php";
include "../app/controller/controller.php";
include  "../app/core/init.php";
include WEB_ROOT.'/app/view/template/Template.php';

use core\Init as Init;
use util\Debug as Debug;

\Model\Table\UserSessionTable::setcookie(false);
$session_started = session_start();


Init::getInstance()->login = !(!isset($_SESSION['login']) || $_SESSION['login'] == NULL || !($_SESSION['login']));


#Debug::print_string(getenv('WEBSITE_PEPPER'));

$path = $_SERVER['REQUEST_URI'];

$path_split = explode('/', ltrim($path));
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

$model = 'Model\\'.ucfirst(Init::getInstance()->req_model).'Model';
$controller = 'Controller\\'.ucfirst(Init::getInstance()->req_controller).'Controller';
$obj_controller = new $controller(new $model);

// Methods come after the req_model.
Init::getInstance()->req_method = $path_split[2] ?? '';

if (Init::getInstance()->req_method == '')
    return $obj_controller->index();
if (method_exists($obj_controller, Init::getInstance()->req_method))
    return $obj_controller->{Init::getInstance()->req_method}(Init::getInstance()->req_param);

header('HTTP/1.1 404 Not Found');
die('404 - The method - '.Init::getInstance()->req_method.' - not found');