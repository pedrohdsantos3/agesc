<?php
include("controletemp/topo.php");
$cont->addFile("CONTEUDO","html/editasala.html");
include("classes/salas.class.php");
$salas = new Salas();
$cont->ACTION = "cad_sala.php";
$cont->ABERTURA = "08:00:00"; //Apenas como parâmetros de exemplo
$cont->FECHAMENTO = "18:00:00";

if(isset($_GET["id"])){
  $id = $_GET["id"];
  $salas->setID($id);
  $infosala = $salas->RetSalaUnica();
  foreach($infosala as $info => $i){
    $cont->ID = $id;
    $cont->NOME = $i["sala_nome"];
    $cont->ABERTURA = $i["sala_abertura"];
    $cont->FECHAMENTO = $i["sala_fechamento"];

  }
}

if(isset($_POST["cadastrar"])){
  $salas->PostSala();
  $salas->setID($id);
  $salas->setNome($nome);
  $salas->setAbertura($abertura);
  $salas->setFechamento($fechamento);

  $cadastro = $salas->CadastrarSala();
  if($cadastro == FALSE){
    $redir->Redir("lista_salas.php?c=sucesso");
  }else{
    for($i=0;$i<count($cadastro);$i++){
      $cont->NOME = $nome;
      $cont->MSG = $cadastro[$i];
      $cont->block("BLOCK_MSG");
    }
  }

}

include("controletemp/rodape.php");
?>
