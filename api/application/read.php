<?php
/* Fini */
include_once '../config/database.php';
include_once '../class/application.php';
$config = new Database();
$database = $config->getConnection();
$class = new Application($database);
$id_advertisement = $_GET["id_advertisement"];
if (isset($id_advertisement) && ($id_advertisement != "")) {
    $class->id_advertisement = $id_advertisement;
    $request = $class->read();
    if ($request["response"]) {
        http_response_code(200);
        echo json_encode($request);
    } else {
        http_response_code(500);
        echo json_encode(array("response" => false, "message" => "Request failed."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("response" => false, "message" => "Request failed. Please check params."));
}
?>