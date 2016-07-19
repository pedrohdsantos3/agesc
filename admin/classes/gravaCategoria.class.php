<?php

    include("classes/categorias.class.php");
    $categoria = new Categoria();


    $categoria->setAtivo(1);
    $categoria->setNome($titulo);

    $valid = $categoria->Valida_categoria();
    if($valid == TRUE){
      $categoria->Cad_categoria();
      $redir->Redir("listacategoria.php");
    }else {
      $cont->NOME = $titulo;
      $cont->MSG = "Dados inválidos para Categoria.";
      $cont->block("BLOCK_MSG");
    }



?>
