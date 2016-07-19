<?php

//include("classes/contadorVisitas.php");
include("classes/t_header.class.php");
include("classes/t_poll.class.php");
include("classes/t_sidebar.class.php");
include("classes/t_content.class.php");
include("classes/t_mainslide.class.php");
include("classes/t_footer.class.php");
include("../configs/header.class.php");
$redirect = new Redirect();
$baseUrl = $redirect->PegaSite();

$header		= new Header("html/header.html");
$mainslide	= new Mainslide("html/main-slider.html");
$poll		= new Poll("html/tpl-enquete.html");
$sideb		= new Sidebar("html/sidebar.html");
$footer		= new Footer("html/footer.html");

include("classes/datas.class.php");
$datas = new Datas();

include("classes/sitecont.class.php");
$site = new Conteudo();

if(isset($_REQUEST['poll_submit']) == "Votar" && !isset($_COOKIE['pollCookie'.isset($_REQUEST['poll_id'])])){
	if($_REQUEST['poll_id'] > 0){
		$id_poll = $_REQUEST['poll_id'];
		if(isset($_REQUEST['poll_options'])){
			foreach ($_REQUEST['poll_options'] as $key => $id_ipoll) {
				$site->Grava_Votacao($id_poll,$id_ipoll);
			}
			$tempo['hora']		= 3600;
			$tempo['dia']		= $tempo['hora']	* 24;
			$tempo['semana']	= $tempo['dia']		* 7;
			$tempo['mes']		= $tempo['semana']	* 4;
			setCookie("pollCookie$id_poll", $id_poll, time()+$tempo['semana'], "/");
			setCookie("pollCookieIP", $_SERVER['REMOTE_ADDR'], time()+$tempo['semana'], "/");
		}
	}
	unset($_REQUEST['poll_submit']);
	$_REQUEST['poll_submit'] = "";
}

$maislidas = $site->Ret_maislidas();
while($m = $maislidas->fetch(PDO::FETCH_ASSOC)){
	$sideb->ID_MLD		= $m["post_id"];
	$sideb->TITULO_MLD	= utf8_encode($m["post_titulo"]);
	$sideb->IMGMLD		= @getimagesize($m["imagem_link"])?$m["imagem_link"]:$baseUrl."images/posts/padrao.png";
	$sideb->DATE_MLD	= $datas->DataBr($m["post_data"]);
	$sideb->block("BLOCK_ITEMSIDEBARLIDAS");
}

$enquete = $site->Ret_enquete();
$sideb->POLL_ID = 0;
while($enq = $enquete->fetch(PDO::FETCH_ASSOC)){
	if(isset($_COOKIE['pollCookie'.$enq["enq_id"]])){
		continue;
	} else {
		$sideb->POLL_ID		= $enq["enq_id"];
		$sideb->POLL_TITLE	= utf8_encode($enq["enq_titulo"]);
		$sideb->POLL_TYPE	= ($enq["enq_tipo"]==1?'radio':'checkbox');

		$item_enquete = $site->Ret_ienquete($enq["enq_id"]);
		while($ienq = $item_enquete->fetch(PDO::FETCH_ASSOC)){
			$sideb->POLL_ITEMNAME	= utf8_encode($ienq["ie_texto"]);
			$sideb->POLL_ITEMVALOR	= $ienq["ie_id"];
			$sideb->block("BLOCK_ITENSENQUETE");
		}
		break;
	}
}

if($sideb->POLL_ID > 0 && !isset($_COOKIE['pollCookie'.$sideb->POLL_ID])){
	$sideb->block("BLOCK_ENQUETE");
}

$menuprincipal = $site->Ret_menuPrincipal();
while($mp = $menuprincipal->fetch(PDO::FETCH_ASSOC)){
	$sideb->ARQUIVO = $mp["pag_link"];
	$sideb->TITLEPAGE = utf8_encode($mp["pag_titulo"]);
	$sideb->block("BLOCK_MENUPRINCIPAL");
}
