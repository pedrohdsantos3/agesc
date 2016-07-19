<?php
include("controletemp/topo.php");
$cont = new Content("html/listacategorias.html");
    include("classes/categorias.class.php");
    $categoria = new Categoria();
    if(isset($_GET["p"])){
      $pagina = $_GET["p"];
    }else{
      $pagina = "1";
    }
    if(isset($_GET["ex"])){
      $ex = $_GET["ex"];
      $categoria->Inativar_categoria($ex);
      $redir->Redir("listacategoria.php");
    }else {
      unset($ex);
    }




    $total_pag = $categoria->Numpag_categ();
    $lista = $categoria->Ret_categorias($pagina);

    foreach($lista as $list =>$l){
      if($l["categpost_ativo"] == "1"){
        $cont->STATUS = "Ativo";
      }else {
        $cont->STATUS = "Inativo";
      }
      $cont->NOME = $l["categpost_nome"];
      $cont->ID = $l["categpost_id"];
      $cont->block("BLOCK_LINHAS");
    }

    for($i=1;$i<=$total_pag;$i++){
      $cont->P = $i;
      $cont->block("BLOCK_PAGINAS");
    }



include("controletemp/rodape.php");

?>
