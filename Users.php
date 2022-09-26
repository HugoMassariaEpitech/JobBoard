<?php
try {
  $database = new PDO('mysql:host=localhost;dbname=job_board;charset=utf8', 'root', 'root');
} catch (Exception $error) {
  die('Erreur : ' . $error -> getMessage());
}
$Users = $database -> prepare("SELECT * FROM users");
$Users -> execute();
$AllUsers = $Users -> fetchAll();
echo json_encode($AllUsers);
?>