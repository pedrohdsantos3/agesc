<?php
include("controletemp/includes.php");

	$header->TITLE_PAGE = "Notícias";

	$cont = new Content("html/tpl-noticias.html");
	$cont->PAGE = "noticias";

	if(isset($_REQUEST["p"]))
		if($_REQUEST['p'] > 0)
			$pagina = $_REQUEST["p"];
		else
			$pagina = 1;
	else
		$pagina = 1;

	$noticias = $site->Ret_portipo(1,$pagina);
	$total = $site->Total_Ret_portipo(1);
	foreach($noticias as $notic => $no){
		$cont->POST_ID		= $no["post_id"];
		$cont->TITLE_POST	= utf8_encode($no["post_titulo"]);
		$cont->DATE_POST	= $datas->DataBr($no["post_data"]);
		$cont->RESUMO_POST	= utf8_encode($no["post_subtitulo"]);
		$cont->IMG_NT		= @getimagesize($no["imagem_link"])?$no["imagem_link"]:$baseUrl."images/404-image.png";
		$cont->block("BLOCK_ITENSNOTICIAS");
	}

	if($total > 10){
		$lastPagina = ceil($total / 10);
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

	$sideb->block("BLOCK_ITEMSIDEBARLIDAS");

include("controletemp/views.php");
?>
