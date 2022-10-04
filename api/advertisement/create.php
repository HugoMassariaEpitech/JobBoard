<?php
include_once "../config/database.php";
include_once "../class/advertisement.php";
$config = new Database();
$database = $config->getConnection();
$class = new Advertisement($database);
$advertisement_name = $_POST["advertisement_name"];
$advertisement_company = $_POST["advertisement_company"];
$advertisement_location = $_POST["advertisement_location"];
$advertisement_type = $_POST["advertisement_type"];
$advertisement_description = $_POST["advertisement_description"];
if (isset($advertisement_name) && ($advertisement_name != "") && isset($advertisement_company) && ($advertisement_company != "") && isset($advertisement_location) && ($advertisement_location != "") && isset($advertisement_type) && ($advertisement_type != "") && isset($advertisement_description) && ($advertisement_description != "")) {
    $class->advertisement_name = $advertisement_name;
    $class->advertisement_company = $advertisement_company;
    $class->advertisement_location = $advertisement_location;
    $class->advertisement_type = $advertisement_type;
    $class->advertisement_description = $advertisement_description;
    $class->advertisement_details = "{\'Début\': \'09/12/2022\', \'Salaire\': \'5000€\'}";
    $request = $class->createAdvertisement();
    if ($request["response"]) {
        http_response_code(200);
        echo json_encode(array("response" => true, "message" => $request["access"]));
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