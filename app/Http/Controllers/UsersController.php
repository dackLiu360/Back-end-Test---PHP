<?php

namespace App\Http\Controllers;

use Exception;
use InvalidArgumentException;
use App\Models\Addresses;
use App\Models\Cities;
use App\Models\States;
use App\Models\Users;

class UsersController
{

    const USERNAME = 'username';
    const PASSWORD = 'password';
    const ADDRESS = 'address';
    const CITY = 'city';
    const STATE = 'state';
    const FK_USER = 'fk_user';
    const ID = 'id';
    const ERROR_FILLED = 'All the fields must be filled before submit a new user!';
    const ERROR_FILLED_NONE = 'At least one field must be filled !';
    const ERROR_ALREADY_EXISTS = 'Username already exists, please chose another!';
    const ERROR_NOT_FOUND = 'No user was found!';
    const ERROR_NOT_FOUND_ID = 'No user was found by the given id!';
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

    /**
     * Registers an user data 
     */
    public function create()
    {
        try {

            $request = $_POST;

            if (
                empty($request['username']) || empty($request['password']) || empty(['request->address']) ||
                empty($request['city']) ||  empty($request['state'])
            ) {
                throw new InvalidArgumentException(self::ERROR_FILLED);
            }

            if($this->users->findByUsername($request['username'])){
                throw new InvalidArgumentException(self::ERROR_ALREADY_EXISTS);
            }

            $id = $this->users->insert(['username' => $request['username'], 'password' => $request['password']]);
            $this->addresses->insert($id, ['address' => $request['address']]);
            $this->cities->insert($id, ['city' => $request['city']]);
            $this->states->insert($id, ['state' => $request['state']]);

            
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }

        return json_encode(self::SUCCESS_CREATE);
    }

    /**
     * Get an user by the given id
     */
    public function read($id)
    {
        try {
            if (!$user = $this->users->findById($id)) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_ID);
            }
            
            $data['username'] = $user['username'];
            $data['password'] = self::HIDE_PASSWORD;
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }

        return json_encode($data);
    }

    /**
     * Get all the users and infos
     */
    public function readAll()
    {
        try {
            $users = $this->users->findAll();

            if (empty($users)) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND);
            }

            $data = [];

            foreach ($users as $k => $user) {
                $data[$k][self::USERNAME] = $user['username'];
                $data[$k][self::PASSWORD] = self::HIDE_PASSWORD;
                $data[$k][self::ADDRESS] = $this->addresses->findByFkUser($user['id']);
                $data[$k][self::CITY] = $this->cities->findByFkUser($user['id']);
                $data[$k][self::STATE] = $this->states->findByFkUser($user['id']);
            }
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }

        return json_encode($data);
    }

    /**
     * Updates an user info by the given id
     */
    public function update($id)
    {
        $request = $_POST;

        try {
            if (!$user = $this->users->findById($id)) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_ID);
            }

            if (
                empty($request['username']) && empty($request['password']) && empty($request['address']) &&
                empty($request['city']) && empty($request['state'])
            ) {
                throw new InvalidArgumentException(self::ERROR_FILLED_NONE);
            }

            if (isset($request['username'])) {
                $this->users->update($id, ['username' => $request['username']]);
            }

            if (isset($request['password'])) {
                $this->users->update($id, ['password' => $request['password']]);
            }


            if (isset($request['address'])) {
                $this->addresses->update($id, ['address' => $request['address']]);
            }

            if (isset($request['city'])) {
                $this->cities->update($id, ['city' => $request['city']]);
            }

            if (isset($request['state'])) {
                $this->states->update($id, ['state' => $request['state']]);
            }
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }

        return json_encode(self::SUCCESS_UPDATE);
    }

    /**
     *  Deletes an user by the given id
     */
    public function delete($id)
    {
        try {
            if (empty($this->users->delete($id))) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_ID);
            }
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Input');
            return json_encode($e->getMessage());
        }

        return json_encode(self::SUCCESS_DELETE);
    }
}
