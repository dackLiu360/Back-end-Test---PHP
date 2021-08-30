<?php

namespace App\Models;

class Cities
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
}
