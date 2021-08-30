<?php

namespace App\Http\Controllers;

use Exception;
use InvalidArgumentException;

class CitiesController extends MethodsDefaultController
{
    /**
     * Get the city by the given id
     */
    public function read($id)
    {
        try {
            if (!$city = $this->getCityById($id)) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_USER_ID);
            }

            $data['city'] = $city['city'];
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }

        return json_encode($data);
    }

    /**
     * Get all the cities registered
     */
    public function readAll()
    {
        try {
            if (empty($data = $this->getCitiesName())) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_USER);
            }
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }

        return json_encode($data);
    }

    /**
     * Get the total of users related to certain city
     */
    public function readUsersTotalByCity($name)
    {
        try {
            $name = urldecode($name);
            $data = $this->getTotalUsersByCity($name);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }

        return json_encode(self::TOTAL_CITIES . $data['total']);
    }
}
