<?php

include "../configs/conexao.class.php";
$url=$_REQUEST["post_url"];
$ex=$pdo->prepare("select post_id from post where post_url='$url'");
$ex->execute();
foreach($ex as $exInfo=>$exData)
  $id=isset($exData["post_id"])?$exData["post_id"]:"";
 else{
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
}
if ($id==""){
echo "ID N&atilde;o localizado";
exit;
header("Location: 404.php");
}

?>
