<?php

require_once "classes/usuario.class.php";
$user = new Usuario();

$idusu = $user->Ret_porLogin($_SESSION["user"]);

$noticia->setId($id);
$noticia->setUserId($idusu);
$noticia->setTitulo(utf8_decode($titulo));
$noticia->setSubt(utf8_decode($subtitulo));
$noticia->setTipoPost($tpost);
$noticia->setCatId(1);
$noticia->setTexto(stripcslashes($txt));
$noticia->setData($data);

if ($destaque == "on") {
	$destaque = 1;
} else {
	$destaque = 0;
}
$noticia->setDestaque($destaque);

if($anonimo == "on"){
	$anonimo = 1;
}else{
	$anonimo = 0;
}
$noticia->setAnonimo($anonimo);

$valid = $noticia->Valida_noticia();
if ($valid == true) {
	$noticia->setAtivo(1);
	$idpost = $noticia->Editar_noticia();
	if ($_FILES["img"]["size"] > 0 || $_FILES["img"]["name"] != "") {
		include "classes/upload.class.php";
		$upload  = new Upload();
		$caminho = $upload->UploadImage($_FILES["img"]["name"], $_FILES["img"]["tmp_name"]);
		$upload->setImagem($caminho);
		$upload->setIdPost($idpost);
		$upload->setTitulo(utf8_decode($titulo));
		$upload->setAlt(utf8_decode($titulo));
		$upload->setImagem($caminho);
		$upload->UpdateImg();
	}
	$redir->Redir("listanoticias.php");
} else {
	$cont->TITULO	= $titulo;
	$cont->SUBT		= $subtitulo;
	$cont->DATA		= $data;
	$cont->CONTEUDO	= $txt;
	for ($i = 0; $i < count($valid); $i++) {
		$cont->MSG = $valid[$i];
		$cont->block("BLOCK_ITENS_MSG_DANGER");
	}
	$cont->block("BLOCK_MSG_DANGER");
}
