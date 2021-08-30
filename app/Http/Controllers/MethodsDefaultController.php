<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\Cities;
use App\Models\States;
use App\Models\Users;
use Exception;

class MethodsDefaultController 
{

    const ID = 'id';
    const ADDRESS = 'address';
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const CITY = 'city';
    const STATE = 'state';
    const FK_USER = 'fk_user';
    const TOTAL_STATES = 'The total of users registered by the given state found was: ';
    const TOTAL_CITIES = 'The total of users registered by the given city found was: ';
    const ERROR_FILLED = 'All the fields must be filled before submit a new user!';
    const ERROR_FILLED_NONE = 'At least one field must be filled !';
    const ERROR_ALREADY_EXISTS = 'Username already exists, please chose another!';
    const ERROR_NOT_FOUND_USER = 'No user was found!';
    const ERROR_NOT_FOUND_USER_ID = 'No user was found by the given id!';
    const ERROR_NOT_FOUND_ADDRESS_ID = 'No address was found by the given id!';
    const ERROR_NOT_FOUND_ADDRESS = 'No address was found!';
    const ERROR_NOT_FOUND_CITY_ID = 'No city was found by the given id!';
    const ERROR_NOT_FOUND_CITY = 'No city was found!';
    const ERROR_NOT_FOUND_STATE_ID = 'No state was found by the given id!';
    const ERROR_NOT_FOUND_STATE = 'No state was found!';
    const SUCCESS_CREATE = 'User was succesfully created!';
    const SUCCESS_DELETE = 'User was succesfully deleted!';
    const SUCCESS_UPDATE = 'User was succesfully updated!';
    const HIDE_PASSWORD = '******';

    private $users;
    private $addresses;
    private $cities;
    private $states;


    public function __construct($db)
    {
        $this->users = new Users($db);
        $this->addresses = new Addresses($db);
        $this->cities = new Cities($db);
        $this->states = new States($db);
    }


    //Users methods
    protected function insertUser($username, $password, $address, $city, $state)
    {
        try {
            $id = $this->users->insert(['username' => $username, 'password' => $password]);
            $this->addresses->insert($id, ['address' => $address]);
            $this->cities->insert($id, ['city' => $city]);
            $this->states->insert($id, ['state' => $state]);

        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    protected function getUserByUsername($username)
    {
        try {
            return $this->users->findByUsername($username);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    protected function getUserById($id)
    {
        try {
            return $this->users->findById($id);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    protected function getUsersIdUsername()
    {
        try {
            return $this->users->findAll();
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    protected function updateFields($id, $params)
    {
        try {
            foreach($params as $field => $param){
                switch($field){
                    case 'username':
                        $this->users->updateUsername($id, ['username' => $param]);
                        break;

                    case 'password':
                        $this->users->updatePassword($id, ['password' => $param]);
                        break;

                    case 'address':
                        $this->addresses->update($id, ['address' => $param]);
                        break;

                    case 'city':
                        $this->cities->update($id, ['city' => $param]);
                        break;

                    case 'state':
                        $this->states->update($id, ['state' => $param]);
                        break;
                }
            }
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    protected function deleteUserInfo($id)
    {
        try {
            return $this->users->delete($id);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    //Addresses methods
    protected function getAddressById($id)
    {
        try {
            return $this->addresses->findById($id);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    protected function getAddressesName()
    {
        try {
            return $this->addresses->findAll();
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    protected function getAddressByUserId($id)
    {
        try {
            return $this->addresses->findByFkUser($id);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    //Cities methods
    protected function getCityById($id)
    {
        try {
            return $this->cities->findById($id);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    protected function getCitiesName()
    {
        try {
            return $this->cities->findAll();
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    protected function getCityByUserId($id)
    {
        try {
            return $this->cities->findByFkUser($id);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    protected function getTotalUsersByCity($city)
    {
        try {
            return $this->cities->findByName($city);;
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    //States methods
    protected function getStateById($id)
    {
        try {
            return $this->states->findById($id);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    protected function getStateByUserId($id)
    {
        try {
            return $this->states->findByFkUser($id);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    protected function getStatesName()
    {
        try {
            return $this->states->findAll();
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }

    protected function getTotalUsersByState($state)
    {
        try {
            return $this->states->findByName($state);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }
    }
}
