<?php
include("controletemp/topo.php");

	$cont = new Content("html/cadpagina.html");
	$cont->ACTION = "cadpagina.php";
	$cont->NOMEACTION = "Cadastrar";

	if(isset($_POST["cadastrar"])){
		include("classes/postPagina.class.php");
		include("classes/gravaPagina.class.php");
	}

include("controletemp/rodape.php");
?>
