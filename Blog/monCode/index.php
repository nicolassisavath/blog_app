<?php 
session_start();

include('parameters.php');
include('config.php');
include('routes.php');

spl_autoload_register('autoload');

$param_init = [
	'c' => DEFAULT_CONTROLLER,
	'a' => DEFAULT_ACTION 
];

$param = array_merge($param_init, $_GET);

$controllerName = ucfirst($param['c']).'Controller';

$controller = new $controllerName();

$controller->setParam($_GET);
$controller->setData($_POST);

$controller->trigger($param['a']);

// echo '$_SESSION<br>';
// var_dump($_SESSION);
// echo '$_POST<br>';
// var_dump($_POST);


?>