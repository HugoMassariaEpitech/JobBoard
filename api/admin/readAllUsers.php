<?php

/* OK */
include_once '../config/database.php';
include_once '../class/user.php';
$config = new Database();
$database = $config->getConnection();
$class = new User($database);
$request = $class->getUsers();
if ($request["response"]) {
    http_response_code(200);
    echo json_encode(array("response" => true, "message" => $request["result"]));
} else {
    http_response_code(500);
    echo json_encode(array("response" => false, "message" => "Request failed."));
}
