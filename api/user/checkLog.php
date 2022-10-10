<?php
/* OK */
include_once "../config/database.php";
include_once "../class/user.php";
$config = new Database();
$database = $config->getConnection();
$class = new User($database);
$request = $class->checkLogUser();
echo json_encode(array("response" => $request["response"]));
?>