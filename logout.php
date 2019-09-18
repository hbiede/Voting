<?php
require_once("php/functions.php");

if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time(), '/');
}

session_destroy();
redirect("index.php");