<?php
/* OK */
include_once '../config/database.php';
include_once '../class/advertisement.php';
$config = new Database();
$database = $config->getConnection();
$class = new Advertisement($database);
$request = $class->getAdvertisements();
if ($request["response"]) {
    http_response_code(200);
    echo json_encode(array("response" => true, "message" => $request["result"]));
} else {
    http_response_code(500);
    echo json_encode(array("response" => false, "message" => "Request failed."));
}
?>