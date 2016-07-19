<?php
include("controletemp/includes.php");

	$header->TITLE_PAGE = "Not&iacute;cias, Artigos e Relacionadas";

	$cont = new Content("html/tpl-archive.html");

	$noticias = $site->Ret_totalPtipo(1);
	foreach($noticias as $notice =>$no){
		$cont->POST_IDNT = $no["post_id"];
		$cont->TITLE_POSTNT = utf8_encode($no["post_titulo"]);
		$cont->DATE_POSTNT = $datas->DataBr($no["post_data"]);
		$cont->block("BLOCK_ITENSNOTICIAS");
	}
	$artigos = $site->Ret_totalPtipo(3);
	foreach($artigos as $art =>$ar){
		$cont->POST_IDART = $ar["post_id"];
		$cont->TITLE_POSTART = utf8_encode($ar["post_titulo"]);
		$cont->DATE_POSTART = $datas->DataBr($ar["post_data"]);
		$cont->block("BLOCK_ITENSARTIGOS");
	}
	$nrelacionadas = $site->Ret_totalPtipo(2);
	foreach($nrelacionadas as $rel =>$re){
		$cont->POST_ID = $re["post_id"];
		$cont->TITLE_POST = utf8_encode($re["post_titulo"]);
		$cont->DATE_POST = $datas->DataBr($re["post_data"]);
		$cont->block("BLOCK_ITENSNOTICIASRELACIONADAS");
	}

include("controletemp/views.php");
?>
