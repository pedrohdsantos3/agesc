<?php
include("controletemp/topo.php");

    $cont = new Content("html/cadnoticias.html");
    $cont->ACTION = "cadnoticias.php";
    $cont->NOMEACTION = "Cadastrar";

    include("classes/categorias.class.php");

    $categorias = new Categoria();
    $lista = $categorias->Ret_todas();

  

    if(isset($_POST["cadastrar"])){
        include("classes/postCad_noticias.class.php");
        include("classes/gravaNoticia.class.php");
    }

include("controletemp/rodape.php");
?>
