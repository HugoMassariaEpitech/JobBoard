<?php
/* OK */
include_once "../config/database.php";
include_once "../class/advertisement.php";
$config = new Database();
$database = $config->getConnection();
$class = new Advertisement($database);
$id_advertisement = $_GET["id_advertisement"];
if (isset($id_advertisement) && ($id_advertisement != "")) {
    $class->id_advertisement = $id_advertisement;
    $request = $class->getSingleAdvertisement();
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
?>