<?php

class Usuario
{

	public function __construct()
	{
		$this->setID("");
		$this->setAtivo("");
		$this->setNome("");
		$this->setEmail("");
		$this->setLogin("");
		$this->setSenha("");
		$this->setNivel("");
	}

	public function setID($id)
	{
		$this->id = $id;
	}
	public function getID()
	{
		return $this->id;
	}

	public function setAtivo($ativo)
	{
		$this->ativo = $ativo;
	}
	public function getAtivo()
	{
		return $this->ativo;
	}

	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function getNome()
	{
		return $this->nome;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}
	public function getEmail()
	{
		return $this->email;
	}

	public function setLogin($login)
	{
		$this->login = $login;
	}
	public function getLogin()
	{
		return $this->login;
	}

	public function setSenha($senha)
	{
		$this->senha = md5($senha);
	}
	public function getSenha()
	{
		return $this->senha;
	}

	public function setNivel($nivel)
	{
		$this->nivel = $nivel;
	}
	public function getNivel()
	{
		return $this->nivel;
	}

	public function ToArray()
	{
		return get_class_vars(get_class($this));
	}

	public function Nome($usuario)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT usuario_nome FROM usuario WHERE usuario_login = '$usuario'");
		$ex->execute();

		while ($rs = $ex->fetch(PDO::FETCH_ASSOC)) {

			$nome = $rs["usuario_nome"];
		}
		return $nome;
	}

	public function Nivel($usuario)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT usuario_nivel_acesso FROM usuario WHERE usuario_login = '$usuario'");
		$ex->execute();

		while ($rs = $ex->fetch(PDO::FETCH_ASSOC)) {
			$nivel = $rs["usuario_nivel_acesso"];
			if ($nivel < 3) {
				$func = "Operador";
			} elseif ($nivel >= 3) {
				$func = "Administrador";
			}

		}
		return $func;
	}

	public function Cad_usuario()
	{
		include "../configs/conexao.class.php";
		include "classes/uniqueid.class.php";
		$uniqueid = new Uniqueid();

		$this->id = $uniqueid->gera_id();

		$parametros = array(
			":id"		=> $this->id,
			":ativo"	=> $this->ativo,
			":nome"		=> $this->nome,
			":login"	=> $this->login,
			":senha"	=> $this->senha,
			":nivel"	=> $this->nivel
		);

		$ex = $pdo->prepare("INSERT INTO usuario (usuario_id, usuario_ativo, usuario_nome,
				usuario_login, usuario_senha, usuario_nivel_acesso) VALUES (:id, :ativo,
				:nome, :login, :senha, :nivel)");

		$ex->execute($parametros);
	}

	public function Editar_usuario()
	{
		include "../configs/conexao.class.php";

		$parametros = array(
			":id"		=> $this->id,
			":ativo"	=> $this->ativo,
			":nome"		=> $this->nome,
			":login"	=> $this->login,
			":senha"	=> $this->senha,
			":nivel"	=> $this->nivel
		);

		$ex = $pdo->prepare("UPDATE usuario SET usuario_ativo = :ativo,
			usuario_nome = :nome, usuario_login = :login, usuario_senha = :senha,
			usuario_nivel_acesso = :nivel WHERE usuario_id = :id");

		$ex->execute($parametros);
	}

	public function Excluir_usuario($id, $user)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("DELETE FROM usuario WHERE usuario_id = '$id' AND
			usuario_login <> '$user'");
		$ex->execute();
	}

	public function Ret_usuarios($pag)
	{
		include "../configs/conexao.class.php";

		$porpag = 10;
		$ini    = ($pag - 1) * $porpag;
		$ex     = $pdo->prepare("SELECT * FROM usuario LIMIT $ini, $porpag");
		$ex->execute();
		return $ex;
	}

	public function Ret_porLogin($usr)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM usuario WHERE usuario_login = '$usr'");
		$ex->execute();

		while ($rs = $ex->fetch(PDO::FETCH_ASSOC)) {
			$id = $rs["usuario_id"];
		}

		return $id;
	}

	public function Ret_unico($id)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM usuario WHERE usuario_id = '$id'");
		$ex->execute();

		return $ex;
	}

	public function Numpag_usuarios()
	{
		include "../configs/conexao.class.php";

		$porpag = 10;
		$ex = $pdo->query("SELECT count(*) as total FROM usuario")->fetch(PDO::FETCH_OBJ);
		$numPag = ceil($ex->total / $porpag);

		return $numPag;
	}

	public function Verifica_existencia()
	{
		include "../configs/conexao.class.php";
		$parametros = array(":login" => $this->login);
		$ex         = $pdo->prepare("SELECT usuario_login FROM usuario WHERE usuario_login = :login");
		$ex->execute($parametros);

		if ($ex->rowCount() > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function Valida_usuario()
	{

		$pass = strlen($this->senha);
		$name = strlen($this->nome);
		$user = strlen($this->login);

		$erros = 0;
		if ($pass < 6 || $pass > 32) {
			$erros++;
		} elseif ($name > 150 || $name < 1) {
			$erros++;
		} elseif ($user > 25 || $user < 3) {
			$erros++;
		}
		$verifica = $this->Verifica_existencia();
		if ($verifica == false) {
			$erros++;
		}
		if ($erros > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function Valida_edicao()
	{

		$pass = strlen($this->senha);
		$name = strlen($this->nome);
		$user = strlen($this->login);

		$erros = 0;
		if ($pass < 6 || $pass > 32) {
			$erros++;
		} elseif ($name > 150 || $name < 1) {
			$erros++;
		} elseif ($user > 25 || $user < 3) {
			$erros++;
		}
		if ($erros > 0) {
			return false;
		} else {
			return true;
		}
	}

}
