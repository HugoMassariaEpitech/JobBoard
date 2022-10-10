<?php
/* OK */
include_once "../config/database.php";
include_once "../class/user.php";
include_once "../class/applies.php";

$config = new Database();
$database = $config->getConnection();
$class = new Applies($database);
$user = new User($database);
$request = $user->checkLogUser();


if ($request["response"]) {

    $tokenParts = explode(".", $_COOKIE["token"]);
    $payload = base64_decode($tokenParts[1]);
    $decode = json_decode($payload);

    $class->user_email = get_object_vars($decode)["user_email"];
    $class->id_advertisement = $_POST["id_advertisement"];
    $class->user_phone = get_object_vars($decode)["user_phone"];
    $class->user_firstname = get_object_vars($decode)["user_firstname"];
    $class->user_name = get_object_vars($decode)["user_name"];


    if ($class->createApply()) {
        http_response_code(200);
        echo json_encode(array("response" => true, "message" => "created"));
    } else {
        echo json_encode(array("response" => false, "message" => "not created"));
    }
} else {

    $class->user_email = $_POST["user_email"];
    $class->id_advertisement = $_POST["id_advertisement"];
    $class->user_phone = $_POST["user_phone"];
    $class->user_firstname = $_POST["user_firstname"];
    $class->user_name = $_POST["user_name"];
    if ($class->createApply()) {
        http_response_code(200);
        echo json_encode(array("response" => true, "message" => "created"));
    } else {
        echo json_encode(array("response" => false, "message" => "not created"));
    }
}
