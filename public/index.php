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
        echo $userController->create();
        break; 

    case 'findUserById':
        if(empty($uri[3])){
            header("HTTP/1.1 404 Not Found");
            echo json_encode('Not Found method!');
            break;
        }

        echo $userController->read($uri[3]);
        break; 

    case 'findAllUsers':
        echo $userController->readAll();
        break; 

    case 'updateUser':
        if(empty($uri[3])){
            header("HTTP/1.1 404 Not Found");
            echo json_encode('Not Found method!');
            break;
        }

        echo $userController->update($uri[3]);
        break; 

    case 'deleteUser':
        if(empty($uri[3])){
            header("HTTP/1.1 404 Not Found");
            echo json_encode('Not Found method!');
            break;
        }

        echo $userController->delete($uri[3]);
        break; 

    case 'findAllAdresses':
        echo $addressControler->readAll();
        break; 

    case 'findAddressById':
        if(empty($uri[3])){
            header("HTTP/1.1 404 Not Found");
            echo json_encode('Not Found method!');
            break;
        }

        echo $addressControler->read($uri[3]);
        break; 

    case 'findAllCities':
        echo $citiesController->readAll();
        break; 

    case 'findCityById':
        if(empty($uri[3])){
            header("HTTP/1.1 404 Not Found");
            echo json_encode('Not Found method!');
            break;
        }

        echo $citiesController->read($uri[3]);
        break; 

    case 'findAllStates':
        echo $statesController->readAll();
        break; 

    case 'findStateById':
        if(empty($uri[3])){
            header("HTTP/1.1 404 Not Found");
            echo json_encode('Not Found method!');
            break;
        }

        echo $statesController->read($uri[3]);
        break; 

    case 'findUsersTotalByCity':
        if(empty($uri[3])){
            header("HTTP/1.1 404 Not Found");
            echo json_encode('Not Found method!');
            break;
        }

        echo $citiesController->readUsersTotalByCity($uri[3]);
        break; 

    case 'findUsersTotalByState':
        if(empty($uri[3])){
            header("HTTP/1.1 404 Not Found");
            echo json_encode('Not Found method!');
            break;
        }

        echo $statesController->readUsersTotalByState($uri[3]);
        break;
        
    default:
        header("HTTP/1.1 404 Not Found");
        echo json_encode('Not Found method!');
        break;
}


$userId = null;
if (isset($uri[2])) {
    $userId = (int) $uri[2];
}