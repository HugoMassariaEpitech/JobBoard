<?php
include_once "../config/database.php";
include_once "../class/application.php";
include_once "../class/connexion.php";
$config = new Database();
$database = $config->getConnection();
$classApplication = new Application($database);
$id_advertisement = $_POST["id_advertisement"];
$user_email = $_POST["user_email"];
$classUser = new Connexion($database);
$requestUser = $classUser->checkLog();
if (isset($id_advertisement) && ($id_advertisement != "")) {
    $requestUser = $classUser->checkLog();
    if ($requestUser["response"]) {
        $tokenParts = explode(".", $_COOKIE["token"]);
        $payload = json_decode(base64_decode($tokenParts[1]));
        if (get_object_vars($payload)["admin"]) {
            if (isset($user_email) && ($user_email != "")) {
                $classApplication->id_advertisement = $id_advertisement;
                $classApplication->user_email = $user_email;
                $requestApplication = $classApplication->delete();
                if ($requestApplication["response"]) {
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
        } else {
            $classApplication->id_advertisement = $id_advertisement;
            $classApplication->user_email = get_object_vars($payload)["user_email"];
            $requestApplication = $classApplication->delete();
            if ($requestApplication["response"]) {
                http_response_code(200);
                echo json_encode(array("response" => true));
            } else {
                http_response_code(500);
                echo json_encode(array("response" => false, "message" => "Request failed."));
            }
        }
    } else {
        http_response_code(403);
        echo json_encode(array("response" => false, "message" => "Request failed. Access forbidden."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("response" => false, "message" => "Request failed. Please check params."));
}
?>