<?php
try {
  $pdo = new PDO('mysql:host=localhost;dbname=site_sindasp','root','');
} catch (PDOException $e) {

  echo $e->getMessage();
  exit;
}




?>
