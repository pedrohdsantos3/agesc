<?php


$protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
$site = $protocol. $_SERVER['SERVER_NAME'] .'/';

header("Location: ".$site."../admin/index.php");


?>
