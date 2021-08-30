<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addresses 
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
}
