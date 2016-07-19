<?php
include("controletemp/topo.php");

    $cont = new Content("html/cadagenda.html");
    $cont->ACTION = "cadagenda.php";
    $cont->NOMEACTION = "Cadastrar";

    if(isset($_POST["cadastrar"])){
        include("classes/postAgenda.class.php");
        include("classes/gravaAgenda.class.php");
    }

include("controletemp/rodape.php");
?>
