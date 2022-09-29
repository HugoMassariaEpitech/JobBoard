<?php
include_once "../class/session.php";
$class = new Session();
if ($class->startSession()) {
    echo true;
} else {
    echo false;
}
?>