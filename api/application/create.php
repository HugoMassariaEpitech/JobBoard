<?php
/* Fini */
include_once "../config/database.php";
include_once "../class/application.php";
$config = new Database();
$database = $config->getConnection();
$class = new Application($database);
$id_advertisement = $_POST["id_advertisement"];
$id_user = $_POST["id_user"];
$user_firstname = $_POST["user_firstname"];
$user_name = $_POST["user_name"];
$user_email = $_POST["user_email"];
$user_phone = $_POST["user_phone"];
if (isset($id_advertisement) && ($id_advertisement != "")) {
    if (isset($_COOKIE["token"])) {
        $tokenParts = explode(".", $_COOKIE["token"]);
        $payload = json_decode(base64_decode($tokenParts[1]));
        $signature = hash_hmac("sha256", $tokenParts[0] . "." . $tokenParts[1], "90zgLEniSbKFrV6OJjVa825KcTI1JC7m", true);
        $base64UrlSignature = str_replace(["+", "/", "="], ["-", "_", ""], base64_encode($signature));
        if ($base64UrlSignature == $tokenParts[2]) {
            $class->id_advertisement = $id_advertisement;
            $class->id_user = get_object_vars($payload)["id_user"];
            $class->user_firstname = get_object_vars($payload)["user_firstname"];
            $class->user_name = get_object_vars($payload)["user_name"];
            $class->user_email = get_object_vars($payload)["user_email"];
            $class->user_phone = get_object_vars($payload)["user_phone"];
            $request = $class->create();
            if ($request["response"]) {
                http_response_code(200);
                echo json_encode(array("response" => true));
            } else {
                http_response_code(500);
                echo json_encode(array("response" => false, "message" => "Request failed."));
            }
        } else {
            http_response_code(403);
            echo json_encode(array("response" => false, "message" => "Request failed. Access forbidden."));
        }
    } else {
        if (isset($user_firstname) && ($user_firstname != "") && isset($user_name) && ($user_name != "") && isset($user_email) && ($user_email != "") && isset($user_phone) && ($user_phone != "")) {
            $class->id_advertisement = $id_advertisement;
            $class->user_firstname = $user_firstname;
            $class->user_name = $user_name;
            $class->user_email = $user_email;
            $class->user_phone = $user_phone;
            $request = $class->create();
            if ($request["response"]) {
                http_response_code(200);
                echo json_encode(array("response" => true));
            } else {
                http_response_code(500);
                echo json_encode(array("response" => false, "message" => "Request failed."));
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