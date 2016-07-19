<?php
//require_once "classes/usuario.class.php";
$usuario = new Usuario();

$usuario->setID($id);
$usuario->setAtivo(1);
$usuario->setNome($nome);
$usuario->setLogin($login);
$usuario->setEmail($email);
$usuario->setSenha($senha);
$usuario->setNivel($nivel);

$valid = $usuario->Valida_edicao();
if ($valid == true) {
    $usuario->Editar_usuario();
    $redir->Redir("listausuario.php");
} else {
    $cont->NOME  = $nome;
    $cont->LOGIN = $login;
    $cont->EMAIL = $email;
    $cont->SENHA = $senha;
    $cont->MSG   = "Dados inválidos para Usuário.";
    $cont->block("BLOCK_MSG");
}
