<?php

namespace App\Http\Controllers;

use Exception;
use InvalidArgumentException;
class UsersController extends MethodsDefaultController
{
    /**
     * Registers an user data 
     */
    public function create()
    {
        $request = $_POST;

        try {
            if (
                empty($request['username']) || empty($request['password']) || empty($request['address']) ||
                empty($request['city']) ||  empty($request['state'])
            ) {
                throw new InvalidArgumentException(self::ERROR_FILLED);
            }

            if($this->getUserByUsername($request['username'])){
                throw new InvalidArgumentException(self::ERROR_ALREADY_EXISTS);
            }

            $this->insertUser($request['username'], $request['password'], $request['address'], $request['city'], $request['state']);
            
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
            if (!$user = $this->getUserById($id)) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_USER_ID);
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
            $users = $this->getUsersIdUsername();

            if (empty($users)) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_USER);
            }

            $data = [];

            foreach ($users as $k => $user) {
                $data[$k][self::USERNAME] = $user['username'];
                $data[$k][self::PASSWORD] = self::HIDE_PASSWORD;
                $data[$k][self::ADDRESS] = $this->getAddressByUserId($user['id']);
                $data[$k][self::CITY] = $this->getCityByUserId($user['id']);
                $data[$k][self::STATE] = $this->getStateByUserId($user['id']);
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
            if (!$this->getUserById($id)) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_USER_ID);
            }

            $params = [
                'username' => empty($request['username']) ? false : $request['username'],
                'password' => empty($request['password']) ? false : $request['password'],
                'address' => empty($request['address']) ? false : $request['address'],
                'city' => empty($request['city']) ? false : $request['city'],
                'state' => empty($request['state']) ? false : $request['state'],
            ];

            if (
                !$params['username'] && !$params['password'] && !$params['address'] &&
                !$params['city'] && !$params['state']
            ) {
                throw new InvalidArgumentException(self::ERROR_FILLED_NONE);
            }


            if (isset($request['username'])) {
                $this->updateFields($id, ['username' => $request['username']]);
            }

            if (isset($request['password'])) {
                $this->updateFields($id, ['password' => $request['password']]);
            }


            if (isset($request['address'])) {
                $this->updateFields($id, ['address' => $request['address']]);
            }

            if (isset($request['city'])) {
                $this->updateFields($id, ['city' => $request['city']]);
            }

            if (isset($request['state'])) {
                $this->updateFields($id, ['state' => $request['state']]);
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
            if (empty($this->deleteUserInfo($id))) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_USER_ID);
            }
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Input');
            return json_encode($e->getMessage());
        }

        return json_encode(self::SUCCESS_DELETE);
    }
}
