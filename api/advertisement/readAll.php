<?php
include_once '../config/database.php';
include_once '../class/advertisement.php';
$config = new Database();
$database = $config->getConnection();
$class = new Advertisement($database);
echo $class->getAdvertisements();
?>