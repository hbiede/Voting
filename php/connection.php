<?php

require_once("constants.php");

ob_start();
session_start();
session_name("BiedeVoting");

$connection = @mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
if (!$connection) {
    die("Connection failed: " . @mysqli_error($connection));
}