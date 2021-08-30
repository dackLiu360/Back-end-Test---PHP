<?php

namespace App\Http\Controllers;

use Exception;
use InvalidArgumentException;

class AddressesController extends MethodsDefaultController
{
    /**
     * Get the adress by the given id
     */
    public function read($id)
    {
        try {
            if (!$address = $this->getAddressById($id)) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_ADDRESS_ID);
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
            if (empty($data = $this->getAddressesName())) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_ADDRESS);
            }
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }

        return json_encode($data);
    }
}
