<?php
namespace App\Http\Controllers;

use Exception;
use InvalidArgumentException;
use App\Models\States;

class StatesController {

    const ID = 'id';
    const STATE = 'state';
    const ERROR_NOT_FOUND_ID = 'No state was found by the given id!';
    const ERROR_NOT_FOUND = 'No state was found!';
    const TOTAL_STATES = 'The total of users registered by the given state found was: ';
    
    private $states;


    public function __construct($db)
    {
        $this->states = new States($db);
    }

    /**
     * Get the state by the given id
     */
    public function read($id)
    {
        try {
            if (!$state = $this->states->findById($id)) {
                throw new InvalidArgumentException(self::ERROR_NOT_FOUND_ID);
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
            if (empty($data = $this->states->findAll())) {
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
    public function readUsersTotalByState($name)
    {
        try {
            $name = urldecode($name);
            $data = $this->states->findByName($name);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Invalid Data');
            return json_encode($e->getMessage());
        }

        return json_encode(self::TOTAL_STATES . $data['total']);
    }
}