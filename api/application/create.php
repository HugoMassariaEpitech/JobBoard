<?php
/* Fini */
include_once "../config/database.php";
include_once "../class/application.php";
include_once "../class/connexion.php";
$config = new Database();
$database = $config->getConnection();
$classApplication = new Application($database);
$id_advertisement = $_POST["id_advertisement"];
$user_firstname = $_POST["user_firstname"];
$user_name = $_POST["user_name"];
$user_email = $_POST["user_email"];
$user_phone = $_POST["user_phone"];
$classUser = new Connexion($database);
$requestUser = $classUser->checkLog();
if (isset($id_advertisement) && ($id_advertisement != "") && (!ctype_space($user_email)) && (!ctype_space($user_phone)) && (!ctype_space($user_name)) && (!ctype_space($user_firstname))) {
    $requestUser = $classUser->checkLog();
    if((filter_var($user_email, FILTER_VALIDATE_EMAIL)) && (preg_match("'^(?:7|0\d|\+94\d)\d{8}$'", $user_phone))){
        if ($requestUser["response"]) {
            $tokenParts = explode(".", $_COOKIE["token"]);
            $payload = json_decode(base64_decode($tokenParts[1]));
            $classApplication->id_advertisement = $id_advertisement;
            $classApplication->user_firstname = get_object_vars($payload)["user_firstname"];
            $classApplication->user_name = get_object_vars($payload)["user_name"];
            $classApplication->user_email = get_object_vars($payload)["user_email"];
            $classApplication->user_phone = get_object_vars($payload)["user_phone"];
            $requestApplication = $classApplication->create();
            if ($requestApplication["response"]) {
                http_response_code(200);
                echo json_encode(array("response" => true));
            } else {
                if ($requestApplication["applied"]) {
                    http_response_code(200);
                    echo json_encode(array("response" => false, "message" => "Request failed. Already applied."));
                } else {
                    http_response_code(500);
                    echo json_encode(array("response" => false, "message" => "Request failed."));
                }
            }
    }else{
            http_response_code(400);
            echo json_encode(array("response" => false, "message" => "Request failed. Please check params."));
        }

    } else {
        if (isset($user_firstname) && ($user_firstname != "") && isset($user_name) && ($user_name != "") && isset($user_email) && ($user_email != "") && isset($user_phone) && ($user_phone != "")) {
            $classApplication->id_advertisement = $id_advertisement;
            $classApplication->user_firstname = $user_firstname;
            $classApplication->user_name = $user_name;
            $classApplication->user_email = $user_email;
            $classApplication->user_phone = $user_phone;
            $request = $classApplication->create();
            if ($request["response"]) {
                http_response_code(200);
                echo json_encode(array("response" => true));
            } else {
                if ($request["applied"]) {
                    http_response_code(200);
                    echo json_encode(array("response" => false, "message" => "Request failed. Already applied."));
                } else {
                    http_response_code(500);
                    echo json_encode(array("response" => false, "message" => "Request failed."));
                }
            }
        } else {
            http_response_code(400);
            echo json_encode(array("response" => false, "message" => "Request failed. Please check params."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("response" => false, "message" => "Request failed. Please check params."));
}
?>