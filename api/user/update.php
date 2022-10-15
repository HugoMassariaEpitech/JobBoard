<?php
include_once "../config/database.php";
include_once "../class/user.php";
$config = new Database();
$database = $config->getConnection();
$class = new User($database);
$user_firstname = $_POST["user_firstname"];
$user_name = $_POST["user_name"];
$user_phone = $_POST["user_phone"];
if (isset($user_firstname) && ($user_firstname != "") && (!ctype_space($user_firstname))  && isset($user_name) && ($user_name != "") && (!ctype_space($user_name))  && isset($user_phone) && ($user_phone != "") && (!ctype_space($user_phone)) && (preg_match("'^(?:7|0\d|\+94\d)\d{8}$'", $user_phone))){
    $class->user_firstname = $user_firstname;
    $class->user_name = $user_name;
    $class->user_phone = $user_phone;
    $request = $class->update();
    if ($request["response"]) {
        http_response_code(200);
        setcookie("token", $request["result"], time() + 3600, "/", "", true, true);
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
?>