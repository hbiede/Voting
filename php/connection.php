<?php

require_once("constants.php");

$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (!$connection) {
    die("Connection failed: " . mysqli_error($connection));
}