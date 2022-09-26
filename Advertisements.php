<?php
try {
  $database = new PDO('mysql:host=localhost;dbname=job_board;charset=utf8', 'root', 'root');
} catch (Exception $error) {
  die('Erreur : ' . $error -> getMessage());
}
$Advertisements = $database -> prepare("SELECT * FROM advertisements");
$Advertisements -> execute();
$AllAdvertisements = $Advertisements -> fetchAll();
echo json_encode($AllAdvertisements);
?>