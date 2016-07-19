<?php
include("controletemp/topo.php");
$cont = new Content("html/listausuario.html");

    require_once("classes/usuario.class.php");
    $usuarios = new Usuario();
    if(isset($_GET["p"])){
      $pagina = $_GET["p"];
    }else{
      $pagina = "1";
    }
    if(isset($_GET["ex"])){
      $ex = $_GET["ex"];
      $usuarios->Excluir_usuario($ex, $_SESSION["user"]);
    }else {
      unset($ex);
    }




    $total_pag = $usuarios->Numpag_usuarios();
    $lista = $usuarios->Ret_usuarios($pagina);

    foreach($lista as $list =>$l){
      $cont->NOME = utf8_encode($l["usuario_nome"]);
      $cont->LOGIN = $l["usuario_login"];
      $cont->ID = $l["usuario_id"];
      $cont->block("BLOCK_LINHAS");
    }

    for($i=1;$i<=$total_pag;$i++){
      $cont->P = $i;
      $cont->block("BLOCK_PAGINAS");
    }



include("controletemp/rodape.php");

?>
