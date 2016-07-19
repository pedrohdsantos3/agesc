<?php
    include("controletemp/topo.php");
         $cont = new Content("html/index.html");
         $cont->MSG = "Admin Login";
         if(isset($_REQUEST["e"])){
           $cont->MSG = "Usuário ou Senha inválidos.";
         }
    include("controletemp/rodape.php");
?>
