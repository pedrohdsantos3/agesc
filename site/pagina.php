<?php
include("controletemp/includes.php");

	if(!$_REQUEST["c"]){
		header("Location: 404.php");
	} else {
		$pageName = $_REQUEST["c"];
	}

	$cont = new Content("html/tpl-pagina.html");
	$conteudo = @file_get_contents("html/paginas/".$pageName);

	$tituloP = $site->Ret_pagTitulo($pageName);
	if(trim($tituloP) == "" || trim($tituloP) == NULL ){
		preg_match_all('#<div class="composs-panel-title"><strong>(.*?)</strong></div>#sim', $conteudo, $titulo);
		$tituloP = $titulo[1][0];
	}

	$header->TITLE_PAGE = utf8_encode($tituloP);

	$cont->CONTEUDOPAGINA = $conteudo;
	$cont->block("BLOCK_CONTEUDOPAGINA");
	$cont->block("BLOCK_TPLPAGINA");
	$sideb->block("BLOCK_ITEMSIDEBARLIDAS");

include("controletemp/views.php");
?>
