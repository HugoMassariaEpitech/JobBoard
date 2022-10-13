<?php
/* Fini */
include_once "../config/database.php";
include_once "../class/application.php";
include_once "../class/connexion.php";

$config = new Database();
$database = $config->getConnection();
$class = new Application($database);
$id_advertisement = $_POST["id_advertisement"];
$user_firstname = $_POST["user_firstname"];
$user_name = $_POST["user_name"];
$user_email = $_POST["user_email"];
$user_phone = $_POST["user_phone"];
$user = new Connexion($database);
$request = $user->checkLog();




if ($request["response"]) {
    if(isset($id_advertisement) && ($id_advertisement != "")){
        if(isset($_COOKIE["token"]) && $_COOKIE["token"] != ""){

            $tokenParts = explode(".", $_COOKIE["token"]);
            $payload = base64_decode($tokenParts[1]);
            $decode = json_decode($payload);

            $class->user_email = get_object_vars($decode)["user_email"];
            $class->id_advertisement =  $id_advertisement;
            $class->user_phone = get_object_vars($decode)["user_phone"];
            $class->user_firstname = get_object_vars($decode)["user_firstname"];
            $class->user_name = get_object_vars($decode)["user_name"];

            $requestApply = $class->create();

        }
    }

    if ($requestApply["response"]) {
        http_response_code(200);
        echo json_encode(array("response" => true, "message" => "created"));
    } else {
        http_response_code(500);
        echo json_encode(array("response" => false, "message" => "Request failed."));
    }
} else {
    if((isset($user_firstname) && ($user_firstname != "") && isset($user_name) && ($user_name != "") && isset($user_email) && ($user_email != "") && isset($user_phone) && ($user_phone != ""))){
    $class->user_email = $user_email;
    $class->id_advertisement = $id_advertisement;
    $class->user_phone = $user_phone;
    $class->user_firstname = $user_firstname;
    $class->user_name = $user_name;
    $requestApply = $class->create();

        if ($requestApply["response"]) {
            http_response_code(200);
            echo json_encode(array("response" => true, "message" => "created"));
        } else {
            http_response_code(500);
            echo json_encode(array("response" => false, "message" => "Request failed. You're already subscribed."));
        }
    }
    else {
        echo json_encode(array("response" => false, "message" => "Check params."));
    }

}



?>