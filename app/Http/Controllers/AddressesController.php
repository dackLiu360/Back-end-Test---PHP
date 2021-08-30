<?php
namespace App\Http\Controllers;

use Exception;
use InvalidArgumentException;
use App\Models\Addresses;

class AddressesController {

    const ID = 'id';
    const ADDRESS = 'address';
    const ERROR_NOT_FOUND_ID = 'No address was found by the given id!';
    const ERROR_NOT_FOUND = 'No address was found!';

    private $addresses;


    public function __construct($db)
    {
        $this->addresses = new Addresses($db);
    }


    /**
     * Get the adress by the given id
     */
    public function read($id)
    {
        try {
            if (!$address = $this->addresses->findById($id)) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_ID);
            }
            
            $data['address'] = $address['address'];
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }

        return json_encode($data);
    }


    /**
     * Get all the adresses registered
     */
    public function readAll()
    {
        try {
            if (empty($data = $this->addresses->findAll())) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND);
            }
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }

        return json_encode($data);
    }
   
}