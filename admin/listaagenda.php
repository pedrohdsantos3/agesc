<?php
include("controletemp/topo.php");
$cont = new Content("html/listaagenda.html");
    include("classes/agenda.class.php");
    $agenda = new Agenda();
    if(isset($_GET["p"])){
      $pagina = $_GET["p"];
    }else{
      $pagina = "1";
    }
    if(isset($_GET["ex"])){
      $ex = $_GET["ex"];
      $agenda->Excluir_evento($ex);
      $redir->Redir("listaagenda.php");
    }else {
      unset($ex);
    }




    $total_pag = $agenda->Numpag_agenda();
    $lista = $agenda->Ret_eventos($pagina);

    foreach($lista as $list =>$l){

      $cont->NOME = $l["ag_titulo"];
      $cont->ID = $l["id"];
      $cont->block("BLOCK_LINHAS");
    }

    for($i=1;$i<=$total_pag;$i++){
      $cont->P = $i;
      $cont->block("BLOCK_PAGINAS");
    }



include("controletemp/rodape.php");

?>
