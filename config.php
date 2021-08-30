<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

include("config/database.php");


$dotenv = new DotEnv(__DIR__);
$dotenv->load();

$dbConnection = (new Database())->getConnection();
