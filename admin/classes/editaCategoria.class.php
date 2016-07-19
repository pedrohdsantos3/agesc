<?php

    $categoria->setId($id);
    $categoria->setNome($titulo);

    $valid = $categoria->Valida_edicao();
    if($valid == TRUE){
      $categoria->Editar_categoria();
      $redir->Redir("listacategoria.php");
    }else {
      $cont->NOME = $titulo;
      $cont->MSG = "Dados inválidos para Categoria.";
      $cont->block("BLOCK_MSG");
    }



?>
