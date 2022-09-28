<?php
include_once "../config/database.php";
include_once "../class/user.php";
$config = new Database();
$database = $config->getConnection();
$class = new User($database);
$user_name = $_POST["user_name"];
$user_password = $_POST["user_password"];
$user_email = $_POST["user_email"];
if (isset($user_email) && ($user_email != "") && isset($user_name) && ($user_name != "") && isset($user_password) && ($user_password != "")) {
    $class->user_email = $user_email;
    $class->user_name = $user_name;
    $class->user_password = $user_password;
    http_response_code(200);
    echo $class->registerUser();
} else {
    http_response_code(404);
}
?>