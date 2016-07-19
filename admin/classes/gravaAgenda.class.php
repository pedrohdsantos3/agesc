<?php

    include("classes/agenda.class.php");
    $agenda = new Agenda();
    require_once("classes/usuario.class.php");
    $user = new Usuario();

    $idusu = $user->Ret_porLogin($_SESSION["user"]);

    $agenda->setUserId($idusu);
    $agenda->setTitulo($titulo);
    $agenda->setDataIni($datainicio);
    $agenda->setDataFim($datafim);
    $agenda->setObs($obs);

    $valid = $agenda->Valida_agenda();
    if($valid == TRUE){
      $agenda->NovoEvento();
      $redir->Redir("listaagenda.php");
    }else {
      $cont->DESC = $titulo;
      $cont->DATA_INICIO = $datainicio;
      $cont->DATA_FIM = $datafim;
      $cont->CONTEUDO = $obs;
      $cont->MSG = "Evento já existe.";
      $cont->block("BLOCK_MSG");
    }



?>
