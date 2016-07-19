<?php
include "controletemp/topo.php";

$cont             = new Content("html/editausuario.html");
$cont->ACTION     = "cadusuario.php";
$cont->NOMEACTION = "Cadastrar";

if (isset($_POST["cadastrar"])) {
	include "classes/postUsuario.class.php";
	include "classes/gravaUsuario.class.php";
}

include "controletemp/rodape.php";
