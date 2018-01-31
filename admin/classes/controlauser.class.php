<?php
//echo "aqui";exit;
include("classes/verificalogin.class.php");
$controle = new Verificalogin();
if(isset($_SESSION["user"]))
	$usuario = $_SESSION["user"];
else
	$usuario = 0;

if(isset($_SESSION["senha"]))
	$senha = $_SESSION["senha"];
else
	$senha = 0;
$nome = $_SERVER["SCRIPT_NAME"];
$nomep = basename($nome);
$login = $controle->validaLogin($usuario, $senha);
if($login == FALSE){
	//echo "oi login";exit;
$redir->Directout("index.php");}

$direitos = $controle->valida_dir($nomep, $usuario);
if($direitos == FALSE){
	include("classes/t_content.class.php");
	$cont = new Content("html/erro500.html");
	$cont->show();
}

?>
