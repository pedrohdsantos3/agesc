<?php
include "controletemp/topo.php";

$cont				= new Content("html/editausuario.html");
$cont->ACTION		= "editausuario.php";
$cont->NOMEACTION	= "Editando";

if (isset($_REQUEST["id"])) {
	$id = $_REQUEST["id"];
} else {
	$id = 0;
}
$cont->ID = $id;

require_once "classes/usuario.class.php";
$usuario = new Usuario();

$infos = $usuario->Ret_unico($id);
foreach ($infos as $inf => $in) {
	$cont->NOME		= $in["usuario_nome"];
	$cont->LOGIN	= $in["usuario_login"];
	$cont->EMAIL	= $in["usuario_email"];
	$cont->SENHA	= "";
}

if (isset($_POST["cadastrar"])) {
	include "classes/postUsuario.class.php";
	include "classes/editaUsuario.class.php";
}

include "controletemp/rodape.php";
