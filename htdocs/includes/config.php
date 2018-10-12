<?php

define('DB_HOST', 'localhost');
define('DB_PORT', '5432');
define('DB_NAME', 'carpool');
define('DB_USER', 'postgres');
define('DB_PASS', 'test');

$conn_str  = 'host=' . DB_HOST . ' ';
$conn_str .= 'port=' . DB_PORT . ' ';
$conn_str .= 'dbname=' . DB_NAME . ' ';
$conn_str .= 'user=' . DB_USER . ' ';
$conn_str .= 'password=' . DB_PASS;

?>