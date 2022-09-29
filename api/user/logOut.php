<?php
include_once "../config/database.php";
include_once "../class/user.php";
$config = new Database();
$database = $config->getConnection();
$class = new User($database);
if ($class->logOutUser()) {
    echo true;
} else {
    echo false;
}
?>