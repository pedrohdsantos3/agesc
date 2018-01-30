<?php
include("controletemp/topo.php");
$cont->addFile("CONTEUDO","html/listausuario.html");
include("classes/usuarios.class.php");
$usuarios = new Usuario();

$pag = (isset($_REQUEST["pag"]))?$_REQUEST["pag"]:1;

if(isset($_GET["ex"])){
  $ex = $_GET["ex"];
  $usuarios->setID($ex);
  $usuarios->setLogin($usuario);
  $usuarios->Excluir_usuario();
  $redir->Redir("lista_usuarios.php?exc=".$ex);
}

if(isset($_GET["exc"])){
  $cont->MSG = "Usuário ".$_GET["exc"]." excluído com sucesso.";
  $cont->block("BLOCK_MSG");
}

if(isset($_GET["c"])){
  $cont->MSG = "Cadastro Efetuado com Sucesso.";
  $cont->block("BLOCK_MSG");
}

$lista = $usuarios->Ret_usuarios($pag);
while($users = $lista->fetch(PDO::FETCH_ASSOC)){
    $cont->ID = $users["usu_id"];
    $cont->NOME = utf8_encode($users["usu_nome"]);
    $cont->NIVEL = utf8_encode($users["nivel_nome"]);
    $cont->LOGIN = $users["usu_email"];
    $cont->block("BLOCK_LINHAS");
}



$paginas = $usuarios->Numpag_usuarios();
for($i=1;$i<=$paginas;$i++){
  $cont->P =$i;
  $cont->block("BLOCK_PAGINAS");
}
include("controletemp/rodape.php");
?>
