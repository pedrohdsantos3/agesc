<?php
include("controletemp/includes.php");

	$header->TITLE_PAGE = "Agenda SINDASP";
	$header->block("BLOCK_CSSAGENDA");

	$cont = new Content("html/tpl-agenda.html");

	$eventos = $site->Ret_eventosAgenda();
	$arrayItensAgenda = "";
	foreach($eventos as $evento => $ev){
		$arrayItensAgenda .= "{
			id: '".$ev['id']."',
			title: '".$ev['ag_titulo']."',
			start: '".$ev['ag_data_inicio']."',
			end: '".$ev['ag_data_fim']."'
		},";
	}
	$footer->JS_ITENS_AGENDA = $arrayItensAgenda;
	$footer->block("BLOCK_JSAGENDA");

include("controletemp/views.php");
?>
