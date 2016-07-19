<?php
include("controletemp/topo.php");

	$cont = new Content("html/cadcategorias.html");
	$cont->ACTION = "cadcategoria.php";
	$cont->NOMEACTION = "Cadastrar";

	if(isset($_POST["cadastrar"])){
		include("classes/postCategoria.class.php");
		include("classes/gravaCategoria.class.php");
	}

include("controletemp/rodape.php");

?>
