<?php
require_once("classes/usuario.class.php");
$usuario = new Usuario();


$nome = "Leonardo";
$login = "leovox";
$senha = "abc159753";
$nivel = "5";

$usuario->setAtivo(1);
$usuario->setNome($nome);
$usuario->setLogin($login);
$usuario->setSenha($senha);
$usuario->setNivel($nivel);

$usuario->Cad_usuario();


?>
