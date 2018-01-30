<?php


      include("menus.class.php");
      $menu = new MontaMenu();
      $menus = $menu->Carrega_menu();

      foreach($menus as $men => $m){
        $cont->MENU = utf8_encode($m["menu_nome"]);
        $menu->setID($m["menu_id"]);

        $paginas = $menu->Ret_paginas();
        foreach($paginas as $pagina => $pa){
          $cont->PAG_NOME = utf8_encode($pa["pag_nome"]);
          $cont->PHP_PAG = $pa["pag_arquivo"];
          $cont->block("BLOCK_ITENSMENU");
        }

        $cont->block("BLOCK_MENU");
      }

 ?>
