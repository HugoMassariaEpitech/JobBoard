<?php
include_once "../config/database.php";
include_once "../class/advertisement.php";
$config = new Database();
$database = $config->getConnection();
$class = new Advertisement($database);
$id_advertisement = $_GET["id_advertisement"];
if (isset($id_advertisement) && ($id_advertisement != "")) {
    $class->id_advertisement = $id_advertisement;
    http_response_code(200);
    echo $class->getSingleAdvertisement();
} else {
    http_response_code(404);
    echo json_encode("Advertisement not found. Please check ID.");
}
?>