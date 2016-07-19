<?php

class Enquete
{

	public function __construct()
	{
		$this->setID("");
		$this->setUserId("");
		$this->setTitulo("");
		$this->setIeTitulo("");
		$this->setAtivo("");
		$this->setTipo("");
		$this->setDate("");
	}

	public function setID($id)
	{
		$this->id = $id;
	}
	public function getID()
	{
		return $this->id;
	}

	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;
	}
	public function getTitulo()
	{
		return $this->titulo;
	}

	public function setIeTitulo($ietitulo)
	{
		$this->ietitulo = $ietitulo;
	}
	public function getIeTitulo()
	{
		return $this->ietitulo;
	}

	public function setDate($date)
	{
		$this->date = $date;
	}
	public function getDate()
	{
		return $this->date;
	}

	public function setAtivo($ativo)
	{
		$this->ativo = $ativo;
	}
	public function getAtivo()
	{
		return $this->ativo;
	}

	public function setTipo($tipo)
	{
		$this->tipo = $tipo;
	}
	public function getTipo()
	{
		return $this->tipo;
	}

	public function setUserId($userid)
	{
		$this->userid = $userid;
	}
	public function getUserId()
	{
		return $this->userid;
	}

	public function NovaEnquete()
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("INSERT INTO enquete (enq_titulo, enq_data, enq_ativo, enq_tipo, usu_id)
			VALUES (:titulo,:date,:ativo,:tipo,:userid)");
		$ex->bindParam(':titulo', $this->titulo);
		$ex->bindParam(':date',   $this->date);
		$ex->bindParam(':ativo',  $this->ativo);
		$ex->bindParam(':tipo',   $this->tipo);
		$ex->bindParam(':userid', $this->userid);
		$ex->execute();
		$lastID = $pdo->lastInsertId();

		foreach (array_filter($this->ietitulo) as $key => $item) {
			$ex2 = $pdo->prepare("INSERT INTO itens_enquete (enq_id, ie_texto) VALUES (:id,:opcao)");
			$ex2->bindParam(':id', $lastID);
			$ex2->bindParam(':opcao', $item);
			$ex2->execute();
		}
	}

	// public function Atualizar_Enquete()
	// {
	// 	include "../configs/conexao.class.php";

	// 	$parametros = array(
	// 		":id"		=> $this->id,
	// 		":titulo"	=> $this->titulo,
	// 		":ativo"	=> $this->ativo,
	// 		":tipo"		=> $this->tipo,
	// 	);

	// 	$ex = $pdo->prepare("UPDATE enquete
	// 		SET enq_titulo = :titulo, enq_ativo = :ativo, enq_tipo = :tipo
	// 		WHERE enq_id = :id");
	// 	$ex->execute($parametros);

	// 	$ex2 = $pdo->prepare("DELETE FROM itens_enquete WHERE enq_id = :id");
	// 	$ex2->bindParam(':id', $this->id);
	// 	$ex2->execute();

	// 	foreach (array_filter($this->ie_titulo) as $key => $item) {
	// 		$ex3 = $pdo->prepare("INSERT INTO itens_enquete (enq_id, ie_texto) VALUES (:id,:opcao)");
	// 		$ex3->bindParam(':id', $this->id);
	// 		$ex3->bindParam(':opcao', $item);
	// 		$ex3->execute();
	// 	}
	// }

	public function Ret_enquetes($pag)
	{
		include("../configs/conexao.class.php");
		$pag = $pag -1;
		$ex = $pdo->prepare("SELECT * FROM enquete
			ORDER BY enq_data DESC LIMIT $pag, 20");
		$ex->execute();

		return($ex);
	}

	public function Ret_unico($id)
	{
		include "../configs/conexao.class.php";
		$ex = $pdo->prepare("SELECT * FROM enquete WHERE enq_id = '$id'");
		$ex->execute();

		return $ex;
	}

	public function Ret_ienquete($id,$order=null,$ascOrDesc="DESC")
	{
		include "../configs/conexao.class.php";
		if($order == null){
			$ex = $pdo->prepare("SELECT * FROM itens_enquete WHERE enq_id = '$id'");
		} else {
			$ex = $pdo->prepare("SELECT * FROM itens_enquete WHERE enq_id = '$id' ORDER BY $order $ascOrDesc");
		}
		$ex->execute();

		return $ex;
	}

	public function Desativar_enquete($id)
	{
		include "../configs/conexao.class.php";
		$ctl = $pdo->prepare("SELECT enq_ativo FROM enquete WHERE enq_id = '$id'");
		$ctl->execute();

		while($rs = $ctl->fetch(PDO::FETCH_ASSOC)){
			$act = ( $rs["enq_ativo"] == 1 ) ? 0 : 1;
		}

		$ex = $pdo->prepare("UPDATE enquete SET enq_ativo = '$act' WHERE enq_id = '$id'");
		$ex->execute();
	}

	public function Zerar_enquete($id)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("UPDATE itens_enquete SET ie_votos = 0 WHERE enq_id = '$id'");
		$ex->execute();
	}

	public function Excluir_enquete($id)
	{
		include("../configs/conexao.class.php");
		$ex = $pdo->prepare("DELETE FROM itens_enquete WHERE enq_id = '$id'");
		$ex->execute();
		$ex = $pdo->prepare("DELETE FROM enquete WHERE enq_id = '$id'");
		$ex->execute();
	}

	public function Valida_enquete()
	{
		include "../configs/conexao.class.php";

		$parametros = array(
			":titulo"	=> $this->titulo,
			":ativo"	=> $this->ativo,
			":tipo"		=> $this->tipo,
		);

		$ex = $pdo->prepare("SELECT * FROM enquete
			WHERE enq_titulo = :titulo
			AND	enq_ativo = :ativo
			AND enq_tipo = :tipo
		");
		$ex->execute($parametros);

		if ($ex->rowCount() > 0) {
			return false;
		} else {
			return true;
		}
	}

	// public function Ret_eventos($pag)
	// {
	// 	include "../configs/conexao.class.php";
	// 	$pag = $pag - 1;
	// 	$ex  = $pdo->prepare("SELECT * FROM enquete
	// 		ORDER BY ag_data_inicio LIMIT $pag, 20");
	// 	$ex->execute();

	// 	return ($ex);

	// }

	public function Numpag_enquete()
	{
		include "../configs/conexao.class.php";

		$porpag = 10;
		$ex = $pdo->query("SELECT count(*) as total FROM enquete")->fetch(PDO::FETCH_OBJ);
		$numPag = ceil($ex->total / $porpag);

		return $numPag;
	}

	public function Num_ienquete($id)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->query("SELECT count(*) as total FROM itens_enquete WHERE enq_id = '$id'")->fetch(PDO::FETCH_OBJ);
		return $ex->total;
	}

	public function Ret_qtdevotos($id)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->query("SELECT sum(ie_votos) as votos FROM itens_enquete WHERE enq_id = '$id'")->fetch(PDO::FETCH_OBJ);
		return $ex->votos;
	}

}
