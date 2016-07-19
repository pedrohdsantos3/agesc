<?php

include("classes/enquete.class.php");
$enquete = new Enquete();
require_once("classes/usuario.class.php");
$user = new Usuario();

$idusu = $user->Ret_porLogin($_SESSION["user"]);
date_default_timezone_set('America/Sao_Paulo');

$enquete->setUserId($idusu);
$enquete->setTitulo($titulo);
$enquete->setAtivo(($ativo==true?1:0));
$enquete->setTipo($tipo);
$enquete->setIeTitulo($ie_titulo);
$enquete->setDate(date("Y-m-d H:i:s"));

$valid = $enquete->Valida_enquete();
if($valid == TRUE){
	$enquete->NovaEnquete();
	$redir->Redir("listaenquete.php");
}else {
	$cont->TITULO		= $titulo;
	$cont->STATUS		= $ativo==1?"checked":"";
	$cont->TIPO1		= $tipo==1?"selected":"";
	$cont->TIPO2		= $tipo==2?"selected":"";
	$cont->ESCOLHA1		= $ie_titulo[0];
	$cont->ESCOLHA2		= $ie_titulo[1];
	$cont->ESCOLHA3		= $ie_titulo[2];
	$cont->ESCOLHA4		= $ie_titulo[3];
	$cont->ESCOLHA5		= $ie_titulo[4];
	$cont->ESCOLHA6		= $ie_titulo[5];
	$cont->ESCOLHA7		= $ie_titulo[6];
	$cont->ESCOLHA8		= $ie_titulo[7];
	$cont->ESCOLHA9		= $ie_titulo[8];
	$cont->ESCOLHA10	= $ie_titulo[9];
	$cont->MSG			= "Enquete já existe.";
	$cont->block("BLOCK_MSG");
}

?>