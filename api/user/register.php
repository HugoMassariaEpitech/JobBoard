<?php
include_once "../config/database.php";
include_once "../class/user.php";
$config = new Database();
$database = $config->getConnection();
$class = new User($database);
$user_name = $_POST["user_name"];
$user_password = $_POST["user_password"];
$user_email = $_POST["user_email"];
$user_phone = $_POST["user_phone"];
$user_birthdate = $_POST["user_birthdate"];
$user_civility = $_POST["user_civility"];
$user_firstname = $_POST["user_firstname"];
if (isset($user_email) && ($user_email != "") && isset($user_name) && ($user_name != "") && isset($user_password) && ($user_password != "") && isset($user_phone) && ($user_phone != "") && isset($user_birthdate) && ($user_birthdate != "") && isset($user_civility) && ($user_civility != "") && isset($user_firstname) && ($user_firstname != "")) {
    $class->user_email = $user_email;
    $class->user_name = $user_name;
    $class->user_password = $user_password;
    $class->user_phone = $user_phone;
    $class->user_birthdate = $user_birthdate;
    $class->user_civility = $user_civility;
    $class->user_firstname = $user_firstname;
    http_response_code(200);
    echo $class->registerUser();
} else {
    http_response_code(404);
}
?>