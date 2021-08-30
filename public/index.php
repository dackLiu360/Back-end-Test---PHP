<?php

require "../config.php";
require '../vendor/autoload.php';

use App\Providers\RouteServiceProvider;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);
$param = empty($uri[3]) ? false : $uri[3];

$controller = new RouteServiceProvider($dbConnection);
echo $controller->validateActions($uri[2], $param);
