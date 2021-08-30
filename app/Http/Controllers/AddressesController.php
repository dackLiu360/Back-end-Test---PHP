<?php
namespace App\Http\Controllers;

use Exception;
use InvalidArgumentException;

class AddressesController {

    const ID = 'id';
    const ADDRESS = 'address';
    const ERROR_NOT_FOUND_ID = 'No address was found by the given id!';
    const ERROR_NOT_FOUND = 'No address was found!';

    /**
     * Get the adress by the given id
     */
    public function read($id)
    {
        try {
            if(empty($data = Addresses::select(self::ADDRESS)->where(self::ID, $request->id)->first())){
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_ID);
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        return response()->json($data);
    }

    /**
     * Get all the adresses registered
     */
    public function readAll()
    {
        try {
            if(empty($data = response()->json(Addresses::select(self::ADDRESS)->distinct()->get()))){
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND);
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        return $data;
    }
   
}