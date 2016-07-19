<?php
include("controletemp/topo.php");
$cont = new Content("html/listaenquete.html");
include("classes/enquete.class.php");
$enquete = new Enquete();

	if(isset($_GET["p"])){
		$pagina = $_GET["p"];
	} else{
		$pagina = "1";
	}

	if(isset($_GET["z"])){
		if($_GET['z'] > 0){
			$z = $_GET["z"];
			$enquete->Zerar_enquete($z);
			// $redir->Redir("listaenquete.php");
		}
	}

	if(isset($_GET["ex"])){
		if($_GET['ex'] > 0){
			$ex = $_GET["ex"];
			$enquete->Desativar_enquete($ex);
			// $redir->Redir("listaenquete.php");
		}
	}

	if(isset($_GET["del"])){
		if($_GET['del'] > 0){
			$del = $_GET["del"];
			$enquete->Excluir_enquete($del);
			// $redir->Redir("listaenquete.php");
		}
	}

	$lista = $enquete->Ret_enquetes($pagina);
	foreach($lista as $list =>$l){
		$cont->ID			= $l["enq_id"];
		$cont->NOME			= utf8_encode($l["enq_titulo"]);
		$cont->STATUS		= ($l["enq_ativo"]==1?"Ativo <a href='listaenquete.php?ex=".$l['enq_id']."'>(Desativar)</a>":"Inativo <a href='listaenquete.php?ex=".$l['enq_id']."'>(Ativar)</a>")."";
		$cont->TIPO			= ($l["enq_tipo"]==1)?"&Uacute;nica":"M&uacute;ltipla";
		$cont->NESCOLHAS	= $enquete->Num_ienquete($l["enq_id"]);
		$cont->QTDEVOTOS	= $enquete->Ret_qtdevotos($l["enq_id"]) . " <a href=listaenquete.php?z=".$l['enq_id'].">(Zerar)</a>";
		$cont->block("BLOCK_LINHAS");
	}

	$total_pag = $enquete->Numpag_enquete();
	for($i=1;$i<=$total_pag;$i++){
		$cont->P = $i;
		$cont->block("BLOCK_PAGINAS");
	}

include("controletemp/rodape.php");
?>