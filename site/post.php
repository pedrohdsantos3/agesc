<?php
//  chdir(__DIR__);
  include("controletemp/includes.php");

  $id="";


  if (isset($_REQUEST["post_url"])) {
  	include "../configs/conexao.class.php";
  	$url=$_REQUEST["post_url"];
  	$ex=$pdo->prepare("select post_id from post where post_url='$url'");
  	$ex->execute();
  	foreach($ex as $exInfo=>$exData)
  		$id=isset($exData["post_id"])?$exData["post_id"]:"";
  } else
    $id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";

  if ($id==""){
		echo "ID N&atilde;o localizado";
		exit;
		header("Location: 404.php");
	}else{
		// $id = $_REQUEST["id"];
		$conteudo = $site->Ret_post($id);
		while($rs = $conteudo->fetch(PDO::FETCH_ASSOC)){
		if(isset($rs['post_id'])){
			$cont					= new Content("html/tpl-post.html");
			$header->TITLE_PAGE		= "Not&iacute;cia: ".utf8_encode($rs["post_titulo"]);
			$header->TITLE_POST		= utf8_encode($rs["post_titulo"]);
			$header->RESUMO_POST	= utf8_encode($rs["post_subtitulo"]);
			$cont->TITLE_POST		= utf8_encode($rs["post_titulo"]);
			$cont->RESUMO_POST		= utf8_encode($rs["post_subtitulo"]);
			$cont->CONTEUDO_POST	= $rs["post_texto"];
			$cont->DATE_POST		= $datas->DataBr($rs["post_data"]);
			if($rs["post_anonimo"] == 0){
				$autor		= ($rs["usuario_nome"]);
				$emailautor	= $rs["usuario_email"];
        $cont->block("BLOCK_AUTOR");
			}

			$cont->NOME_AUTOR	= $autor;
			$cont->EMAIL_AUTOR	= $emailautor;
			if(@getimagesize($rs["imagem_link"])){
				$imgURL = substr_replace($rs["imagem_link"],$baseUrl,0,8);
				$header->IMGPOST	= $imgURL;
				$cont->IMGPOST		= $imgURL;
				$cont->block("BLOCK_IMAGEM");
			} else {
				$header->IMGPOST = $baseUrl."images/posts/padrao.png";
			}
			$cont->URL_SHARE = $baseUrl."post.php?id=".$rs['post_id'];
			$header->URL_SHARE = $baseUrl."post.php?id=".$rs['post_id'];

			$visualizacoes = $site->Mais_lidas($id);
		} else
			header("Location: 404.php");
		}
	}

include("controletemp/views.php");
