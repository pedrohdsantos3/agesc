<?php

require_once "classes/usuario.class.php";
$usuario = new Usuario();

$usuario->setAtivo(1);
$usuario->setNome($nome);
$usuario->setLogin($login);
$usuario->setEmail($email);
$usuario->setSenha($senha);
$usuario->setNivel($nivel);
$valid = $usuario->Valida_usuario();
if ($valid == true) {
    $usuario->Cad_usuario();
    $redir->Redir("listausuario.php");
} else {
    $cont->NOME  = $nome;
    $cont->LOGIN = $login;
    $cont->EMAIL = $email;
    $cont->SENHA = $senha;
    $cont->MSG   = "Dados inválidos para Usuário.";
    $cont->block("BLOCK_MSG");
}
