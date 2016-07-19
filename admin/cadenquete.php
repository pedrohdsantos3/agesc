<?php
include("controletemp/topo.php");

    $cont = new Content("html/cadenquete.html");
    $cont->ACTION = "cadenquete.php";
    $cont->NOMEACTION = "Cadastrar";

    if(isset($_POST["cadastrar"])){
        include("classes/postEnquete.class.php");
        include("classes/gravaEnquete.class.php");
    }

include("controletemp/rodape.php");
?>
