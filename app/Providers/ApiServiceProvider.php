<?php
namespace App\Providers;

use App\Http\Controllers\AddressesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\StatesController;

class ApiServiceProvider
{
    private $usersController;
    private $addressesController;
    private $citiesController;
    private $statesController;

    public function __construct($db)
    {
        $this->usersController = new UsersController($db);
        $this->addressesController = new AddressesController($db);
        $this->citiesController = new CitiesController($db);
        $this->statesController = new StatesController($db);
    }

    public function validateActions($action, $param = false)
    {

        switch ($action) {
            case 'createUser':
                return $this->usersController->create();
                break;

            case 'findUserById':
                if (empty($param)) {
                    header("HTTP/1.1 404 Not Found");
                    return json_encode('Not Found method!');
                    break;
                }

                return $this->usersController->read($param);
                break;

            case 'findAllUsers':
                return $this->usersController->readAll();
                break;

            case 'updateUser':
                if (empty($param)) {
                    header("HTTP/1.1 404 Not Found");
                    return json_encode('Not Found method!');
                    break;
                }

                return $this->usersController->update($param);
                break;

            case 'deleteUser':
                if (empty($param)) {
                    header("HTTP/1.1 404 Not Found");
                    return json_encode('Not Found method!');
                    break;
                }

                return $this->usersController->delete($param);
                break;

            case 'findAllAdresses':
                return $this->addressesController->readAll();
                break;

            case 'findAddressById':
                if (empty($param)) {
                    header("HTTP/1.1 404 Not Found");
                    return json_encode('Not Found method!');
                    break;
                }

                return $this->addressesController->read($param);
                break;

            case 'findAllCities':
                return $this->citiesController->readAll();
                break;

            case 'findCityById':
                if (empty($param)) {
                    header("HTTP/1.1 404 Not Found");
                    return json_encode('Not Found method!');
                    break;
                }

                return $this->citiesController->read($param);
                break;

            case 'findAllStates':
                return $this->statesController->readAll();
                break;

            case 'findStateById':
                if (empty($param)) {
                    header("HTTP/1.1 404 Not Found");
                    return json_encode('Not Found method!');
                    break;
                }

                return $this->statesController->read($param);
                break;

            case 'findUsersTotalByCity':
                if (empty($param)) {
                    header("HTTP/1.1 404 Not Found");
                    return json_encode('Not Found method!');
                    break;
                }

                return $this->citiesController->readUsersTotalByCity($param);
                break;

            case 'findUsersTotalByState':
                if (empty($param)) {
                    header("HTTP/1.1 404 Not Found");
                    return json_encode('Not Found method!');
                    break;
                }

                return $this->statesController->readUsersTotalByState($param);
                break;

            default:
                header("HTTP/1.1 404 Not Found");
                return json_encode('Not Found method!');
                break;
        }
    }
}
