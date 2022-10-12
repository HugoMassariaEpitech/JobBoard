<?php
/* Fini */
include_once "../config/database.php";
include_once "../class/connexion.php";
$config = new Database();
$database = $config->getConnection();
$class = new Connexion($database);
$request = $class->checkLog();
echo json_encode(array("response" => $request["response"], "admin" => get_object_vars($request["result"])["admin"]));
?>