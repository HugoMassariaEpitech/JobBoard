<?php

/* OK */
include_once "../config/database.php";
include_once "../class/user.php";
$config = new Database();
$database = $config->getConnection();
$class = new User($database);
$id_user = $_POST["id_user"];
$user_name = $_POST["user_name"];
$user_email = $_POST["user_email"];
$user_phone = $_POST["user_phone"];
$user_birthdate = $_POST["user_birthdate"];
$user_civility = $_POST["user_civility"];
$user_firstname = $_POST["user_firstname"];
if (isset($id_user) && ($id_user != "") && isset($user_name) && ($user_name != "") && isset($user_email) && ($user_email != "") && isset($user_phone) && ($user_phone != "") && isset($user_birthdate) && ($user_birthdate != "") && isset($user_civility) && ($user_civility != "") && isset($user_firstname) && ($user_firstname != "")) {
    $class->id_user = $id_user;
    $class->user_name = $user_name;
    $class->user_email = $user_email;
    $class->user_phone = $user_phone;
    $class->user_birthdate = $user_birthdate;
    $class->user_civility = $user_civility;
    $class->user_firstname = $user_firstname;
    $request = $class->updateUser();
    if ($request["response"]) {
        http_response_code(200);
        echo json_encode(array("response" => true));
    } else {
        if ($request["access"]) {
            http_response_code(500);
            echo json_encode(array("response" => false, "message" => "Request failed."));
        } else {
            http_response_code(403);
            echo json_encode(array("response" => false, "message" => "Request failed. Access forbidden."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("response" => false, "message" => "Request failed. Please check params."));
}
