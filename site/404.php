<?php
include("controletemp/includes.php");

	$header->TITLE_PAGE = "404 - Página não encontrada!";

	$cont = new Content("html/tpl-404.html");
	$sideb->block("BLOCK_ITEMSIDEBARLIDAS");

include("controletemp/views.php");
?>
