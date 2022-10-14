<?php
/* Fini */
include_once "../config/database.php";
include_once "../class/connexion.php";
$config = new Database();
$database = $config->getConnection();
$class = new Connexion($database);
$request = $class->checkLog();
http_response_code(200);
if ($request["response"]) {
    if ($request["admin"]) {
        echo json_encode(array("response" => true, "admin" => "1"));
    } else {
        echo json_encode(array("response" => true, "admin" => "0", "message" => $request["result"]));
    }
} else {
    echo json_encode(array("response" => false));
}
?>