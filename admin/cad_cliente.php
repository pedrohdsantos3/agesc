<?php
include("controletemp/topo.php");
$cont->addFile("CONTEUDO","html/cadcliente.html");
include("classes/usuarios.class.php");
$usuarios = new Usuario();
// -- \/ Definindo qual será a ação do formulário HTML.
$cont->ACTION = "cad_cliente.php";




include("controletemp/rodape.php");
?>
