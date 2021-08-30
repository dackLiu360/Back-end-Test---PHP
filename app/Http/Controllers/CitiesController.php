<?php
namespace App\Http\Controllers;

use Exception;
use InvalidArgumentException;
use App\Models\Cities;

class CitiesController {

   
    const ID = 'id';
    const CITY = 'city';
    const ERROR_NOT_FOUND_ID = 'No city was found by the given id!';
    const ERROR_NOT_FOUND = 'No city was found!';
    const TOTAL_CITIES = 'The total of users registered by the given city found was: ';
    
    private $cities;


    public function __construct($db)
    {
        $this->cities = new Cities($db);
    }

    /**
     * Get the city by the given id
     */
    public function read($id)
    {
        try {
            if (!$city = $this->cities->findById($id)) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_ID);
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
            if (empty($data = $this->cities->findAll())) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND);
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
            $name = str_replace('%', ' ', $name);
            $data = $this->cities->findByName($name);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }

        return json_encode(self::TOTAL_CITIES . $data['total']);
    }
}