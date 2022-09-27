<?php
include_once "../config/database.php";
include_once "../class/advertisement.php";
$config = new Database();
$database = $config->getConnection();
$class = new Advertisement($database);
$id_advertisement = $_POST["id_advertisement"];
$advertisement_name = $_POST["advertisement_name"];
$advertisement_company = $_POST["advertisement_company"];
$advertisement_location = $_POST["advertisement_location"];
$advertisement_type = $_POST["advertisement_type"];
$advertisement_description = $_POST["advertisement_description"];
if (isset($id_advertisement) && ($id_advertisement != "") && isset($advertisement_name) && ($advertisement_name != "") && isset($advertisement_company) && ($advertisement_company != "") && isset($advertisement_location) && ($advertisement_location != "") && isset($advertisement_type) && ($advertisement_type != "") && isset($advertisement_description) && ($advertisement_description != "")) {
    $class->id_advertisement = $id_advertisement;
    $class->advertisement_name = $advertisement_name;
    $class->advertisement_company = $advertisement_company;
    $class->advertisement_location = $advertisement_location;
    $class->advertisement_type = $advertisement_type;
    $class->advertisement_description = $advertisement_description;
    http_response_code(200);
    echo $class->updateAdvertisement();
} else {
    http_response_code(404);
    echo json_encode("Missing data. Advertisement can't be updated.");
}
?>