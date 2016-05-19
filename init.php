<?php

require_once("API.php");

/**
 * Configuration.
 */
$host = 'localhost';
$username = 'admin';
$password = 'adminpassword';
$database = 'rest_api';

$humans = new API();
$humans->init($host, $username, $password, $database);