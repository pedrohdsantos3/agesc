<?php

class Salas
{

	public function __construct()
	{
		$this->setID("");
		$this->setNome("");
		$this->setAbertura("");
		$this->setFechamento("");
		$this->setUsuario("");
	}

	public function setID($id)
	{
		$this->id = $id;
	}
	public function getID()
	{
		return $this->id;
	}

	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function getNome()
	{
		return $this->nome;
	}

	public function setAbertura($abertura)
	{
		$this->abertura = $abertura;
	}
	public function getAbertura()
	{
		return $this->abertura;
	}

	public function setFechamento($fechamento)
	{
		$this->fechamento = $fechamento;
	}
	public function getFechamento()
	{
		return $this->fechamento;
	}

	public function setUsuario($usuario)
	{
		$this->usuario = $usuario;
	}
	public function getUsuario()
	{
		return $this->usuario;
	}

	public function setData($data)
	{
		$this->data = $data;
	}
	public function getData()
	{
		return $this->data;
	}

	public function PostSala(){
		$__campos = array("nome", "abertura", "fechamento", "id", "data");

		foreach($__campos as $c){
		  $_v_=isset($_POST[$c])?$_POST[$c]:"";

			  if(is_string($_v_))
			      $_v_=trim($_v_);
			  $GLOBALS[$c]=$_v_;
			}
			unset($_v_);

	}

	public function ValidaId(){
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM salas WHERE sala_id = '$this->id'");
		$ex->execute();

		if($ex->rowCount()>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function CadastrarSala()
	{
		include "../configs/conexao.class.php";
		include "classes/uniqueid.class.php";
		$uniqueid = new Uniqueid();


		//print_r($validarCad);exit;
		$parametros = array(
			":id"		=> $this->id,
			":nome"		=> $this->nome,
			":abertura"	=> $this->abertura,
			":fechamento"	=> $this->fechamento,
		);

		if($validaid = $this->ValidaId() == TRUE){
			$validaEdicao = $this->validaEdicao();
			if($validaEdicao == TRUE){
				$ex = $pdo->prepare("UPDATE salas
				SET sala_nome = :nome, sala_abertura = :abertura, sala_fechamento = :fechamento
				WHERE sala_id = :id");
				$ex->execute($parametros);
				return false;
			}else{
				return $validaEdicao;
			}
		}else{
			$validarCad = $this->ValidaSala();
				if($validarCad == false){
						$parametros[":id"] = $this->id = $uniqueid->gera_id();

						$ex = $pdo->prepare("INSERT INTO salas (sala_id, sala_nome,
								sala_abertura, sala_fechamento)
								VALUES (:id, :nome, :abertura, :fechamento)");

						$ex->execute($parametros);

						print_r($ex);exit;

					return false;
					}else{
						return $validarCad;
					}
		}

	}

	public function RetSalaUnica(){
		include "../configs/conexao.class.php";
		$id = $this->id;
		$ex = $pdo->prepare("SELECT * FROM salas WHERE sala_id = '$id'");
		$ex->execute();

		return $ex;
	}

	public function ExcluirSala()
	{
		$id = $this->id;
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("DELETE FROM salas WHERE sala_id = '$id'");
		$ex->execute();
		//print_r($ex);exit;
	}

	public function NumPagSalas()
	{
		include "../configs/conexao.class.php";

		$porpag = 10;
		$ex = $pdo->query("SELECT count(*) as total FROM salas")->fetch(PDO::FETCH_OBJ);
		$numPag = ceil($ex->total / $porpag);

		return $numPag;
	}

	public function PermiteExcluirReserva(){
		include "../configs/conexao.class.php";
			$idusu = $this->usuario;
			$idres = $this->id;
			$ex = $pdo->prepare("SELECT * FROM reservas
			WHERE user_id = '$idusu' AND res_id = '$idres' " );
			$ex->execute();
			//print_r($ex);exit;
			if($ex->rowCount()>0){
				return TRUE;
			}else{
				return FALSE;
			}


	}

	public function ExcluirReserva(){
		include "../configs/conexao.class.php";
		$idres = $this->id;

		$ex = $pdo->prepare("DELETE FROM reservas WHERE res_id = '$idres'");
		$ex->execute();

	}

	public function RetSalas($pag)
	{
		include "../configs/conexao.class.php";

		$porpag = 10;
		$ini    = ($pag - 1) * $porpag;
		$ex = $pdo->prepare("SELECT * FROM salas");
		$ex->execute();
		return $ex;
	}

	public function ReservarSala(){
		include "../configs/conexao.class.php";
		$parametros = array(
			':idsala' => $this->id ,
	 		':idusu' => $this->usuario,
			':data' => $this->data);
			$controle = $this->ControleReservas();
			if($controle == FALSE){
				$ex = $pdo->prepare("INSERT INTO reservas (user_id, sala_id, dia_hora) VALUES
				(:idusu, :idsala, :data)");
				$ex->execute($parametros);
				//print_r($ex->execute());exit;
			}else{
				return $controle;
			}

			//print_r($ex);exit;



	}

	public function ControleReservas(){
		include "../configs/conexao.class.php";

			$horafim = date('H:i:s', strtotime('+1 hour',strtotime($this->data)));
			$validarHoraUsu = $pdo->prepare("SELECT dia_hora FROM reservas WHERE dia_hora = '$this->data'
			AND user_id = '$this->usuario' OR '$this->data'
			BETWEEN dia_hora AND '$horafim' ");
			$validarHoraUsu->execute();

			//print_r($validarHoraUsu);exit;

			$validaHoraSala = $pdo->prepare("SELECT dia_hora FROM reservas WHERE dia_hora = '$this->data'
			OR '$this->data' BETWEEN dia_hora AND '$horafim'");
			$validaHoraSala->execute();

			//print_r($validaHoraSala);exit;

			$desc = [];
			$erro =0;
			if($validarHoraUsu->rowCount()>0){
					$desc[] = "Usuário possui outro agendamento neste horário.";
					return $desc;
			}elseif($validaHoraSala->rowCount()>0){
					$desc[] = "Sala já possui um agendamento para este horário, por favor confira a tabela com os horários já agendados para esta sala.";
					return $desc;
			}else{
				return FALSE;
			}

	}

	public function ListaReservas(){
		include "../configs/conexao.class.php";
		$id = $this->id;
		$ex = $pdo->prepare("SELECT r.*, u.* FROM reservas r
		INNER JOIN usuarios u ON r.user_id = u.usu_id
		WHERE r.sala_id = '$id' ");
		$ex->execute();

		return $ex;
	}

	public function RetSalaId()
	{
		include "../configs/conexao.class.php";
		$id = $this->id;
		$ex = $pdo->prepare("SELECT s.*, r.* FROM salas s
		INNER JOIN reservas r ON a.sala_id = r.reserva_id");
		$ex->execute();
		//print_r($ex);exit;

		return $ex;
	}

	private function VerificaExistencia()
	{
		include "../configs/conexao.class.php";
		$ex         = $pdo->prepare("SELECT sala_nome FROM salas WHERE sala_nome = '$this->nome'");
		$ex->execute();

		//print_r($ex);exit;

		if ($ex->rowCount() > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function ValidaSala()
	{

		$name = strlen($this->nome);

		$erros = 0;
		$desc = [];
		if ($name > 32 || $name < 1) {
			$desc[] = "Nome inválido";
			$erros++;
		}
		$verifica = $this->VerificaExistencia();
		if ($verifica == false) {
			$desc[] = "Esta sala já existe.";
			$erros++;
		}
		if ($erros > 0) {
			return $desc;
		} else {
			return false;
		}
	}

	public function ValidaEdicao()
	{

		$name = strlen($this->nome);

		$erros = 0;
		$desc =[];

	 if($name > 150 || $name < 1) {
			$desc[] = "Nome inválido";
			$erros++;
		}
		if ($erros > 0) {
			return $desc;
		} else {
			return true;
		}
	}

}
