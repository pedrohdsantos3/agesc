<?php

    require_once("classes/usuarios.class.php");
    $usuario = new Usuario();

    $nome = "Pedro Henrique";
    $username = "pedrohdsantos";
    $senha = "s91635304,.";
    $cpf = "38593468810";
    $email = "pedrohdsantos3@gmail.com";
    $cep = "19034030";

    $usuario->setNome($nome);
    $usuario->setLogin($username);
    $usuario->setSenha($senha);
    $usuario->setCpf($cpf);
    $usuario->setEmail($email);
    $usuario->setCep($cep);
    $usuario->setNivel(1);

    $usuario->Cad_usuario();

?>