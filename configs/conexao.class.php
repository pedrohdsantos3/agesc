<?php

try{

$pdo = new PDO('mysql:host=localhost;dbname=radyn_db','root','');
} catch (PDOException $e) {

    echo $e->getMessage();
    exit;
  }

?>
