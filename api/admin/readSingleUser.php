<?php

/* OK */
include_once "../config/database.php";
include_once "../class/user.php";
$config = new Database();
$database = $config->getConnection();
$class = new User($database);
$id_user = $_GET["id_user"];
if (isset($id_user) && ($id_user != "")) {
    $class->id_user = $id_user;
    $request = $class->getSingleUser();
    if ($request["response"]) {
        http_response_code(200);
        if (empty($request["result"])) {
            echo json_encode(array("response" => true, "message" => "Ressource not found."));
        } else {
            echo json_encode(array("response" => true, "message" => $request["result"]));
        }
    } else {
        http_response_code(500);
        echo json_encode(array("response" => false, "message" => "Request failed."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("response" => false, "message" => "Request failed. Please check params."));
}
