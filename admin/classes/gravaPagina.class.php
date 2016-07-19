<?php

include "classes/paginas.class.php";
$pagina = new Pagina();

require_once "classes/usuario.class.php";
$user = new Usuario();

$idusu = $user->Ret_porLogin($_SESSION["user"]);

$pagina->setTitulo($titulo);
$pagina->setConteudo($txt);
$pagina->setUserId($idusu);
$data = date("Y-m-d H:i:s");
$pagina->setData($data);
if ($menup == "on") {
    $menup = 1;
} else {
    $menup = 0;
}
$pagina->setMenu($menup);
$pagina->setLink(strtolower(str_replace(" ", "-", $titulo)));
$valid = $pagina->Ver_existencia();

if ($valid == true) {
    $pagina->Cria_html();
    $pagina->Cad_pagina();
    $redir->Redir("listapaginas.php");
} else {
    $cont->TITULO   = $titulo;
    $cont->CONTEUDO = $txt;
    $cont->MSG      = "Página já existe";
    $cont->block("BLOCK_MSG");
}
