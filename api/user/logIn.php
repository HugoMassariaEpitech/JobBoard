<?php
include_once "../config/database.php";
include_once "../class/user.php";
$config = new Database();
$database = $config->getConnection();
$class = new User($database);
$user_email = $_POST["user_email"];
$user_password = $_POST["user_password"];
if (isset($user_email) && ($user_email != "") && isset($user_password) && ($user_password != "")) {
    $class->user_email = $user_email;
    $class->user_password = $user_password;
    http_response_code(200);
    if ($class->logInUser()) {
        echo true;
    } else {
        echo false;
    }
} else {
    http_response_code(404);
}
?>