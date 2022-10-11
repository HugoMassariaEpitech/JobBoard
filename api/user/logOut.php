<?php
/* OK */
include_once "../config/database.php";
include_once "../class/user.php";
$config = new Database();
$database = $config->getConnection();
$class = new User($database);
http_response_code(200);
setcookie("token", "", -1, "/", "", true, true);
?>