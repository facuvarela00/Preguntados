<?php
session_start();
include_once ("configuration.php");

$config = new configuration();
$router = $config->getRouter();

$controller= $_GET['controller'] ?? 'login';
$method = $_GET['method'] ?? 'execute';


$router->route($controller, $method);

