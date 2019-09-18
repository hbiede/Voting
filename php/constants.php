<?php

ob_start();
session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../session'));
session_start();

define("DB_SERVER", "cse.unl.edu");
define("DB_USERNAME", "hbiede");
define("DB_PASSWORD", "eYq5W@");
define("DB_NAME", "hbiede");