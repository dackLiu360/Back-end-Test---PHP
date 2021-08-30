<?php

require "../config.php";
require '../vendor/autoload.php';

use App\Http\Controllers\AddressesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\StatesController;


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

$userController = new UsersController($dbConnection);
$addressControler = new AddressesController($dbConnection);
$citiesController = new CitiesController($dbConnection);
$statesController = new StatesController($dbConnection);

switch($uri[2]){
    case 'createUser':
        $userController->create();
        break; 

    case 'findUser':
        $userController->read($id);
        break; 

    case 'findAllUsers':
        $userController->readAll();
        break; 

    case 'updateUser':
        $userController->update($params, $id);
        break; 

    case 'deleteUser':
        $userController->delete();
        break; 

    case 'findAllAdresses':
        $addressControler->read($id);
        break; 

    case 'findAdressById':
        $addressControler->readAll();
        break; 

    case 'findAllCities':
        $citiesController->read($id);
        break; 

    case 'findCityById':
        $citiesController->readAll();
        break; 

    case 'findAllStates':
        $statesController->read($id);
        break; 

    case 'findStateById':
        $statesController->readAll();
        break; 

    case 'findUsersTotalByCity':
        $citiesController->readUsersTotalByCity($name);
        break; 

    case 'findUsersTotalByState':
        $statesController->readUsersTotalByState($name);
        break; 
}


$userId = null;
if (isset($uri[2])) {
    $userId = (int) $uri[2];
}