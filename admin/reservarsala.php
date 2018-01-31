<?php
include("controletemp/topo.php");
$cont->addFile("CONTEUDO","html/reservasala.html");
include("classes/salas.class.php");
$salas = new Salas();


if(isset($_GET["id"])){
  $id = $_GET["id"];
  $cont->ID = $id;
  $salas->setID($id);
  $infosala = $salas->RetSalaUnica();
  foreach($infosala as $info => $i){
    $cont->ID = $id;
    $cont->NOME = $i["sala_nome"];
    $cont->ABERTURA = $i["sala_abertura"];
    $cont->FECHAMENTO = $i["sala_fechamento"];
  }
}else{
  $id = 0;
}

if(isset($_GET["ex"])){
  $idres = $_GET["ex"];
  $salas->setID($idres);
  $salas->ExcluirReserva();
  $redir->Redir("reservarsala.php?id=".$id);
}

$salas->setID($id);
$reservas = $salas->ListaReservas();
while($rs = $reservas->fetch(PDO::FETCH_ASSOC)){
  $cont->NOMEUSUARIO = $rs["usu_nome"];
  $cont->DATARESERVA = $rs["dia_hora"];
  $salas->setID($rs["res_id"]);
  $iduser = $controle->RetIdUsuario($usuario);
  $salas->setUsuario($iduser);
  $excluir = $salas->PermiteExcluirReserva();
  if($excluir == TRUE){
    $cont->RESID = $rs["res_id"];
    $cont->block("BLOCK_ACAO");
  }
  $cont->block("BLOCK_LINHAS");
}

if(isset($_POST["cadastrar"])){
  $salas->PostSala();
  $salas->setID($id);
  //echo $usuario;exit;
  $idusuario = $controle->RetIdUsuario($usuario);
  $salas->setUsuario($idusuario);
  $salas->setData($data);

  $cadastro = $salas->ReservarSala();
  if($cadastro == FALSE){
    $redir->Redir("reservarsala.php?id=".$id."&c=sucesso");
  }else{
    for($i=0;$i<count($cadastro);$i++){
      $cont->MSG = $cadastro[$i];
      $cont->block("BLOCK_MSG");
    }
  }

}

include("controletemp/rodape.php");
?>
