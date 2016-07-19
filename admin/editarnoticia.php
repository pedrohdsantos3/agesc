<?php
include("controletemp/topo.php");

    $cont = new Content("html/cadnoticias.html");
    $cont->ACTION = "editarnoticia.php";
    $cont->NOMEACTION = "Atualizar";

    if(isset($_REQUEST["id"])){
      $id = $_REQUEST["id"];
    }else {
      $id = 0;
    }


    include("classes/noticias.class.php");

    $noticia = new Noticias();
    $infos = $noticia->Ret_unica($id);
    foreach($infos as $inf =>$in){
      $cont->TITULO = utf8_encode($in["post_titulo"]);
      $cont->ID = $in["post_id"];
      $cont->SUBT = utf8_encode($in["post_subtitulo"]);
      $cont->DATA = $in["post_data"];
      $cont->CONTEUDO = $in["post_texto"];
      $cont->TPN_SELECTED1 = $in["tipopost_id"]==1?"selected":"";
      $cont->TPN_SELECTED3 = $in["tipopost_id"]==3?"selected":"";
      // $cont->TIPO_POST = $in["tipopost_nome"];
      $cont->IMG = $in["imagem_link"];
      if($in["post_destaque"] == 1){
        $cont->CHECKED = "checked";
      }
      if($in["post_anonimo"] == 1){
        $cont->CHECKEDANONIMO = "checked";
      }

    }
    unset($datas);
    if(isset($_POST["cadastrar"])){
      include("classes/postCad_noticias.class.php");
      include("classes/editarNoticia.class.php");
    }

include("controletemp/rodape.php");
?>
