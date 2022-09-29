<?php
include_once "./api/class/session.php";
$class = new Session();
if ($class->startSession()) {
    header("Location: ./client/client.html");
} else {
    header("Location: ./public/public.html");
}
?>