<?php

namespace App\Http\Controllers;

use Exception;
use InvalidArgumentException;

class StatesController extends MethodsDefaultController
{
    /**
     * Get the state by the given id
     */
    public function read($id)
    {
        try {
            if (!$state = $this->getStateById($id)) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_STATE_ID);
            }

            $data['state'] = $state['state'];
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }

        return json_encode($data);
    }

    /**
     * Get all the states registered
     */
    public function readAll()
    {
        try {
            if (empty($data = $this->getStatesName())) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_STATE);
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
    public function readUsersTotalByState($name)
    {
        try {
            $name = urldecode($name);
            $data = $this->getTotalUsersByState($name);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }

        return json_encode(self::TOTAL_STATES . $data['total']);
    }
}
