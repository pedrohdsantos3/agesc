<?php
include("controletemp/topo.php");
$cont = new Content("html/cadenquete.html");
include("classes/enquete.class.php");
$enquete = new Enquete();

	$cont->ACTION = "editarenquete.php";
	$cont->NOMEACTION = "Atualizar";

	if(isset($_REQUEST["id"])){
		$id = $_REQUEST["id"];
	}else {
		$id = 0;
	}

	$lista = $enquete->Ret_unico($id);
	foreach($lista as $list => $l){
		$cont->ID		= $l["enq_id"];
		$cont->TITULO	= utf8_encode($l["enq_titulo"]);
		$cont->CHECKED	= ($l["enq_ativo"]==1)?"checked":"";
		$cont->SELECT1	= ($l["enq_tipo"]==1)?"selected":"";
		$cont->SELECT2	= ($l["enq_tipo"]==2)?"selected":"";

		$itens = $enquete->Ret_ienquete($id);
		foreach($itens as $key => $i){
			$ie_key = $key+1;
			$ie_titulo = "IE_TITULO$ie_key";
			$cont->$ie_titulo = utf8_encode($i["ie_texto"]);
		}

	}
	unset($datas);
	if(isset($_REQUEST["cadastrar"])){
		include("classes/postEnquete.class.php");
		include("classes/editaEnquete.class.php");
	}

include("controletemp/rodape.php");
?>
