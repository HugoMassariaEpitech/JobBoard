<?php
/* Fini */
include_once "../config/database.php";
include_once "../class/connexion.php";
$config = new Database();
$database = $config->getConnection();
$class = new Connexion($database);
http_response_code(200);
setcookie('token', FALSE, 1, "/","", true, true);
echo json_encode(array("response" => true));
?>