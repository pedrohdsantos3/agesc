<?php
include("controletemp/includes.php");

	$header->TITLE_PAGE = utf8_encode("Notícias Relacionadas");

	$cont = new Content("html/tpl-noticias-relacionadas.html");
	$cont->PAGE = "noticias-relacionadas";

	if(isset($_REQUEST["p"]))
		if($_REQUEST['p'] > 0)
			$pagina = $_REQUEST["p"];
		else
			$pagina = 1;
	else
		$pagina = 1;

	$noticias = $site->Ret_portipoRelacionadasG(2,$pagina);
	$total = $site->Total_Ret_portipo(2);
	foreach($noticias as $notic => $no){
		$cont->POST_ID		= $no["post_id"];
		$cont->TITLE_POST	= utf8_encode($no["post_titulo"]);
		$cont->DATE_POST	= $datas->DataBr($no["post_data"]);
		$cont->RESUMO_POST	= utf8_encode($no["post_subtitulo"]);
		$cont->block("BLOCK_ITENSNOTICIASRELACIONADAS");
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
