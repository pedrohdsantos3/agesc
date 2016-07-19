<?php

  include("classes/conexao.class.php");
  include("classes/uniqueid.class.php");
  $uniqueid = new Uniqueid();
$dir = glob("html/paginas/*.html");
$uduid = "7e570f8fa4a6e012e07165cd6fc69c5b";


foreach($dir as $d){
  $end = explode("/", $d);
  $pagina = $end[2];
  $data = date("Y-m-d H:i:s");
  $idpag = $uniqueid->gera_id();
  $ex = $pdo->prepare("INSERT INTO paginas (pag_id, usuario_id, pag_link, pag_status,
  pag_data) VALUES ('$idpag', '$uduid', '$pagina', '1', '$data' )");
  $ex->execute();

  //print_r($ex);

  echo $pagina."</br>";
}


?>
