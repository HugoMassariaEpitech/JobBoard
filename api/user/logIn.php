<?php
include_once "../config/database.php";
include_once "../class/user.php";
$config = new Database();
$database = $config->getConnection();
$class = new User($database);
$user_name = $_POST["user_name"];
if (isset($user_name) && ($user_name != "")) {
    $class->user_name = $user_name;
    http_response_code(200);
    echo $class->logInUser();
} else {
    http_response_code(404);
}
?>