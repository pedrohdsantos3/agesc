<?php

    $enquete->setID($id);
    $enquete->setTitulo($titulo);
    $enquete->setAtivo($ativo);
    $enquete->setTipo($tipo);
    $enquete->setIeTitulo($ie_titulo);

    $enquete->Atualizar_Enquete();

    $redir->Redir("listaenquete.php");

?>
