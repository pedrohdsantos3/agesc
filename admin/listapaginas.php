<?php
include("controletemp/topo.php");
$cont = new Content("html/listapaginas.html");
    include("classes/paginas.class.php");
    $pagina = new Pagina();
    if(isset($_GET["p"])){
      $p = $_GET["p"];
    }else{
      $p = "1";
    }
    if(isset($_GET["ex"]) && isset($_GET["np"])){
      $ex = $_GET["ex"];
      $np = $_GET["np"];
      $pagina->Apaga_pagina($ex,$np);
    }else {
      unset($ex);
    }




    $total_pag = $pagina->Numpag_post();
    $lista = $pagina->Ret_paginas($p);

    foreach($lista as $list =>$l){
      if($l["pag_status"] == "1"){
        $cont->STATUS = "Ativo";
      }else {
        $cont->STATUS = "Inativo";
      }
      $cont->TITULO = utf8_encode($l["pag_titulo"]);
      $cont->AUTOR = utf8_encode($l["usuario_nome"]);
      $cont->LINK = $l["pag_link"];
      $cont->ID = $l["pag_id"];
      $cont->block("BLOCK_LINHAS");
    }

    for($i=1;$i<=$total_pag;$i++){
      $cont->P = $i;
      $cont->block("BLOCK_PAGINAS");
    }



include("controletemp/rodape.php");

?>
