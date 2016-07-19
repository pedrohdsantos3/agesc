<?php
include("controletemp/topo.php");
$cont = new Content("html/listanoticias.html");
include("classes/noticias.class.php");
$noticias = new Noticias();

	if(isset($_GET["p"])){
		$pagina = $_GET["p"];
	} else{
		$pagina = "1";
	}

	if(isset($_GET["ex"])){
		$ex = $_GET["ex"];
		$noticias->Inativar_post($ex);
	} else {
		unset($ex);
	}

	if(isset($_GET["rep"])){
		$rep = $_GET["rep"];
		$noticias->Repost($rep);
	}

	$total_pag = $noticias->Numpag_post();
	$lista = $noticias->Ret_noticias($pagina);

	foreach($lista as $list =>$l){
		$cont->ID = $l["post_id"];
		$cont->TITULO = utf8_encode($l["post_titulo"]);
		$cont->AUTOR = ($l["usuario_nome"]);

		if($l["post_ativo"] == 1){
			$cont->STATUS = "Ativo";
		}else {
			$cont->STATUS = "Inativo";
		}

		if($l["post_destaque"] == 1){
			$cont->DESTAQUE = "Sim";
		}else {
			$cont->DESTAQUE = "N&atilde;o";
		}

		switch ($l['tipopost_id']) {
			case 1:
				$cont->TIPO = "Posts";
				break;
			case 2:
				$cont->TIPO = "Not&iacute;cias Relacionadas";
				break;
			case 3:
				$cont->TIPO = "Artigos";
				break;
		}
		$cont->block("BLOCK_LINHAS");
	}

	for($i=1;$i<=$total_pag;$i++){
		$cont->P = $i;
		$cont->block("BLOCK_PAGINAS");
	}

include("controletemp/rodape.php");
