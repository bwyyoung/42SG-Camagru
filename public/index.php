<?php
include '../config/config.php';

$name = $_GET['name'] ?? 'CAMAGRU';

header('Content-Type: text/html; charset=utf-8');

if (DEBUG_MODE)
    printf('Debug of program: %s<br>', htmlspecialchars($name, ENT_QUOTES, 'UTF-8'));
    print "\$_SERVER['REQUEST_URI']: ".$_SERVER['REQUEST_URI'].'<br>';
$arrayUri = explode('?', $_SERVER['REQUEST_URI']);


$path = $arrayUri[0];

if (DEBUG_MODE)
    print "The request path is : ".$path;

if ($path == '/')
{
    require_once __DIR__.'/../app/model/indexmodel.php';
    require_once __DIR__.'/../app/controller/indexcontroller.php';
    $req_model = new IndexModel();
    $req_controller = new IndexController($req_model);


}

