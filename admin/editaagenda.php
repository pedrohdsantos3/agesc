<?php
include("controletemp/topo.php");

    $cont = new Content("html/cadagenda.html");
    $cont->ACTION = "editaagenda.php";
    $cont->NOMEACTION = "Gravar";


    if(isset($_REQUEST["id"])){
      $id = $_REQUEST["id"];
    }else {
      $id = 0;
    }
    include("classes/agenda.class.php");
    $agenda = new Agenda();

    $infos = $agenda->Ret_unico($id);
    foreach($infos as $inf =>$i){
      $cont->ID = $i["id"];
      $cont->DESC = $i["ag_titulo"];
      $cont->DATA_INICIO = $i["ag_data_inicio"];
      $cont->DATA_FIM = $i["ag_data_fim"];
      $cont->CONTEUDO = $i["ag_obs"];
    }


    if(isset($_POST["cadastrar"])){
        include("classes/postAgenda.class.php");
        include("classes/editaAgenda.class.php");
    }


include("controletemp/rodape.php");
?>
