<?php
namespace App\Http\Controllers;

use Exception;
use InvalidArgumentException;

class StatesController {

    const ID = 'id';
    const STATE = 'state';
    const ERROR_NOT_FOUND_ID = 'No state was found by the given id!';
    const ERROR_NOT_FOUND = 'No state was found!';
    const TOTAL_STATES = 'The total of users registered by the given state found was: ';

    /**
     * Get the state by the given id
     */
    public function read($id)
    {
        try {
            if(empty($data = States::select(self::STATE)->where(self::ID, $request->id)->first())){
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_ID);
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        return response()->json($data);
    }

    /**
     * Get all the states registered
     */
    public function readAll()
    {
        try {
            if(empty($data = response()->json(States::select(self::STATE)->distinct()->get()))){
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND);
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        return $data;
    }

    /**
     * Get the total of users related to certain city
     */
    public function readUsersTotalByState($name)
    {
        try {
            $data = States::where(self::STATE, $request->state)->count();
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

        return response()->json(self::TOTAL_STATES . $data);
    }
   
}