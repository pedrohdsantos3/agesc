<?php
include("controletemp/topo.php");
$cont->addFile("CONTEUDO","html/listasala.html");
include("classes/salas.class.php");
$salas = new Salas();

$pag = (isset($_REQUEST["pag"]))?$_REQUEST["pag"]:1;

if(isset($_GET["ex"])){
  $ex = $_GET["ex"];
  $salas->setID($ex);
  $salas->ExcluirSala();
  $redir->Redir("lista_salas.php");
}

$lista = $salas->RetSalas($pag);
foreach($lista as $list =>$l){
  $cont->ID = $l["sala_id"];
  $cont->NOME = $l["sala_nome"];
  $cont->ABERTURA = $l["sala_abertura"];
  $cont->FECHAMENTO = $l["sala_fechamento"];
  $podeeditar = $controle->DireitoEdicao($nomep, $usuario);
  if($podeeditar == TRUE){
    $cont->block("BLOCK_EDIT");
  }
  $cont->block("BLOCK_LINHAS");
}





$paginas = $salas->NumPagSalas();
for($i=1;$i<=$paginas;$i++){
  $cont->P =$i;
  $cont->block("BLOCK_PAGINAS");
}
include("controletemp/rodape.php");
?>
