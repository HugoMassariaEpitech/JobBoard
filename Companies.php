<?php
try {
  $database = new PDO('mysql:host=localhost;dbname=job_board;charset=utf8', 'root', 'root');
} catch (Exception $error) {
  die('Erreur : ' . $error -> getMessage());
}
$Companies = $database -> prepare("SELECT * FROM companies");
$Companies -> execute();
$AllCompanies = $Companies -> fetchAll();
echo json_encode($AllCompanies);
?>