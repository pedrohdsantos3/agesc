<?php

    require_once("classes/usuario.class.php");
    $user = new Usuario();

    $idusu = $user->Ret_porLogin($_SESSION["user"]);

    $agenda->setID($id);
    //$agenda->setUserId($idusu);
    $agenda->setTitulo($titulo);
    $agenda->setDataIni($datainicio);
    $agenda->setDataFim($datafim);
    $agenda->setObs($obs);

    $agenda->Atualizar_Evento();

    $redir->Redir("listaagenda.php");


?>
