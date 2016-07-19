<?php
include("controletemp/includes.php");

	$header->TITLE_PAGE = "Resultado da Busca";

	$cont = new Content("html/tpl-search.html");
	$cont->PAGE = "search";

	$busca = -1;
	if(isset($_REQUEST["busca"]))
		$busca = $_REQUEST["busca"];
	elseif(isset($_REQUEST["b"]))
		$busca = $_REQUEST["b"];

	$pagina = 1;
	if(isset($_REQUEST["p"]))
		if($_REQUEST['p'] > 0)
			$pagina = $_REQUEST["p"];

	if($busca != -1){
		$resultado = $site->Ret_pesquisa($busca, $pagina);
		$total = $site->Total_Ret_pesquisa($busca);

		foreach($resultado as $result =>$re){
			$cont->POST_ID = $re["post_id"];
			$cont->TITLE_POST = utf8_encode($re["post_titulo"]);
			$cont->RESUMO_POST = utf8_encode($re["post_subtitulo"]);
			$cont->DATE_POST = $datas->DataBr($re["post_data"]);
			$cont->IMG_NT = @getimagesize($re["imagem_link"])?$re["imagem_link"]:$baseUrl."images/404-image.png";
			$cont->block("BLOCK_ITENS");
		}

		if(count($total) > 10){
			$lastPagina = ceil($total->rowCount() / 10);
			if($pagina == 0){
				$cont->PAGE_ANT = $pagina;
				$cont->block("BLOCK_PAGEANT");
			}elseif($pagina == 1){
				$cont->PAGE_ANT = $pagina+1;
				$cont->block("BLOCK_PAGEANT");
			}elseif($pagina == $lastPagina){
				$cont->PAGE_REC = $pagina-1;
				$cont->block("BLOCK_PAGEREC");
			}else{
				$cont->PAGE_REC = $pagina-1;
				$cont->PAGE_ANT = $pagina+1;
				$cont->block("BLOCK_PAGEREC");
				$cont->block("BLOCK_PAGEANT");
			}
			if($pagina <= $lastPagina){
				$cont->block("BLOCK_PAGINACAO");
			}
		}
	}else{
		unset($cont);
		$cont = new Content("html/tpl-404.html");
	}

	$cont->BUSCA = $busca;

include("controletemp/views.php");
?>
