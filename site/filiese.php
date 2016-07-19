<?php
include("controletemp/includes.php");

	$cont = new Content("html/tpl-filie-se.html");
	$header->TITLE_PAGE = "Filie-se";

	// $cont->block("BLOCK_ERROS");
	// $cont->block("BLOCK_PENITENCIARIA");
	// $cont->block("BLOCK_CARGO");
	$cont->block("BLOCK_DEPENDENTE");

	$sideb->block("BLOCK_ITEMSIDEBARLIDAS");

include("controletemp/views.php");
?>
