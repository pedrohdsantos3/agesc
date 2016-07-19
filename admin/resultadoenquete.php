<?php
include("controletemp/topo.php");
$cont = new Content("html/resultadoenquete.html");
include("classes/enquete.class.php");
$enquete = new Enquete();

	if(isset($_GET["id"])){
		$id = $_GET["id"];
		$enq = $enquete->Ret_unico($id)->fetch(PDO::FETCH_ASSOC);
		$cont->TITULO = utf8_encode($enq['enq_titulo']);
		$cont->STATUS = $enq['enq_ativo']==1?"Ativo":"Inativo";
		$cont->TIPO = $enq['enq_tipo']==1?"Única Escolha":"Múltipla Escolha";
		$cont->DATA = date("d/m/Y H:i:s",strtotime($enq['enq_data']));
		$cont->TOTALVOTOS = $enquete->Ret_qtdevotos($id);
	} else {
		$redir->Redir("listaenquete.php");
	}

	$lista = $enquete->Ret_ienquete($id,'ie_votos','DESC');
	foreach($lista as $list =>$l){
		$cont->ID			= utf8_encode($l["ie_id"]);
		$cont->NOME			= utf8_encode($l["ie_texto"]);
		$cont->QTDEVOTOS	= $l["ie_votos"];
		$cont->PERCVOTOS	= 0;
		if($cont->TOTALVOTOS > 0){
			$resultFull			= ($l["ie_votos"]/$cont->TOTALVOTOS)*100;
			$resultFinal		= (int)($resultFull*100)/100;
			$cont->PERCVOTOS	= $resultFinal;
		}
		$cont->block("BLOCK_LINHAS");
	}

include("controletemp/rodape.php");
?>