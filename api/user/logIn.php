<?php
/* OK */
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
    $request = $class->logInUser();
    if ($request["response"]) {
        http_response_code(200);
        if (empty($request["result"])) {
            echo json_encode(array("response" => false, "message" => "Request failed. Please check params."));
        } else {
            echo json_encode(array("response" => true, "message" => $request["result"], "admin" => $request["admin"]));
        }
    } else {
        http_response_code(500);
        echo json_encode(array("response" => false, "message" => "Request failed."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("response" => false, "message" => "Request failed. Please check params."));
}
?>