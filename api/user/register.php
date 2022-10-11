<?php
/* OK */
include_once "../config/database.php";
include_once "../class/user.php";
$config = new Database();
$database = $config->getConnection();
$class = new User($database);
$user_civility = $_POST["user_civility"];
$user_firstname = $_POST["user_firstname"];
$user_name = $_POST["user_name"];
$user_birthdate = $_POST["user_birthdate"];
$user_phone = $_POST["user_phone"];
$user_email = $_POST["user_email"];
$user_password = $_POST["user_password"];
$password_confirmation = $_POST["password_confirmation"];
if (isset($user_civility) && ($user_civility != "") && isset($user_firstname) && ($user_firstname != "") && isset($user_name) && ($user_name != "") && isset($user_birthdate) && ($user_birthdate != "") && isset($user_phone) && ($user_phone != "") && isset($user_email) && ($user_email != "") && isset($user_password) && ($user_password != "") && isset($password_confirmation) && ($password_confirmation != "")) {
    if ((new DateTime(date("Y-m-d")) < new DateTime($user_birthdate)) || (!preg_match("'^(?:7|0\d|\+94\d)\d{8}$'", $user_phone)) || (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) || (!preg_match("'(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}'", $user_password)) || ($user_password != $password_confirmation)) {
        http_response_code(400);
        echo json_encode(array("response" => false, "message" => "Request failed. Please check params."));
    } else {
        $class->user_civility = $user_civility;
        $class->user_firstname = $user_firstname;
        $class->user_name = $user_name;
        $class->user_birthdate = $user_birthdate;
        $class->user_phone = $user_phone;
        $class->user_email = $user_email;
        $class->user_password = $user_password;
        $request = $class->registerUser();
        if ($request["response"]) {
            http_response_code(200);
            if ($request["registered"]) {
                setcookie("token", $request["result"], time() + 3600, "/", "", true, true); // Set Cookie Path
                echo json_encode(array("response" => true));
            } else {
                echo json_encode(array("response" => false, "message" => "Request failed. Email already used."));
            }
        } else {
            http_response_code(500);
            echo json_encode(array("response" => false, "message" => "Request failed."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("response" => false, "message" => "Request failed. Please check params."));
}
