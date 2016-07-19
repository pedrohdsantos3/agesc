<?php


$protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
$site = $protocol. $_SERVER['SERVER_NAME'] .":".$_SERVER['SERVER_PORT'].'/';

header("Location: ".$site."../admin/index.php");


?>
