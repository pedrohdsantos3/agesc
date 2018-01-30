<?php

class Usuario
{

	public function __construct()
	{
		$this->setID("");
		$this->setNome("");
		$this->setLogin("");
		$this->setEmail("");
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

	public function setNome($nome)
	{
		$this->nome = $nome;
	}
	public function getNome()
	{
		return $this->nome;
	}

	public function setLogin($login)
	{
		$this->login = $login;
	}
	public function getLogin()
	{
		return $this->login;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}
	public function getEmail()
	{
		return $this->email;
	}

	public function setSenha($senha)
	{
		$this->senha = $senha;
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

	public function PostUsuario(){
		$__campos = array("nome", "cargo", "login", "senha", "email", "nivel", "id");

		foreach($__campos as $c){
		  $_v_=isset($_POST[$c])?$_POST[$c]:"";

			  if(is_string($_v_))
			      $_v_=trim($_v_);
			  $GLOBALS[$c]=$_v_;
			}
			unset($_v_);

	}

	public function Nome($usuario)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT usuario_nome FROM usuarios WHERE usuario_login = '$usuario'");
		$ex->execute();

		while ($rs = $ex->fetch(PDO::FETCH_ASSOC)) {

			$nome = $rs["usuario_nome"];
		}
		return $nome;
	}

	public function ValidaId(){
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM usuarios WHERE usu_id = '$this->id'");
		$ex->execute();
		if($ex->rowCount()>0){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	public function Cad_usuario()
	{
		include "../configs/conexao.class.php";
		include "classes/uniqueid.class.php";
		$uniqueid = new Uniqueid();


		//print_r($validarCad);exit;
		$parametros = array(
			":id"		=> $this->id,
			":nome"		=> $this->nome,
			":login"	=> $this->login,
			":email"	=> $this->email,
			":senha"	=> md5($this->senha),
			":nivel"	=> $this->nivel
		);

		if($validaid = $this->ValidaId() == TRUE){
			$validaEdicao = $this->Valida_edicao();
			if($validaEdicao == TRUE){
				$ex = $pdo->prepare("UPDATE usuarios
				SET username = :login, email = :email, usu_direitos = :nivel, password = :senha
				WHERE usu_id = :id");
				$ex->execute($parametros);
				return false;
			}else{
				return $validaEdicao;	
			}
		}else{
			$validarCad = $this->Valida_usuario();
				if($validarCad == false){
						$this->id = $uniqueid->gera_id();
						$parametros[":id"] = $this->id = $uniqueid->gera_id();
						$ex = $pdo->prepare("INSERT INTO usuarios (usu_id, username, email, password, usu_direitos)
								VALUES (:id, :login, :email, :senha, :direitos)");

						$ex->execute($parametros);
					return false;
					}else{
						return $validarCad;
					}
		}

	}

	public function Editar_usuario()
	{
		include "../configs/conexao.class.php";

		$parametros = array(
			":id"		=> $this->id,
			":ativo"	=> $this->ativo,
			":nome"		=> $this->nome,
			":cargo"	=> $this->cargo,
			":login"	=> $this->login,
			":senha"	=> $this->senha,
			":nivel"	=> $this->nivel
		);

		$ex = $pdo->prepare("UPDATE usuarios SET usuario_ativo = :ativo,
			usuario_nome = :nome, usuario_cargo = :cargo, usuario_login = :login,
			usuario_senha = :senha,	usuario_nivel_acesso = :nivel
			WHERE usuario_id = :id");

		$ex->execute($parametros);
	}

	public function Excluir_usuario()
	{
		$id = $this->id;
		$user = $this->login;
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("DELETE FROM usuarios WHERE usu_id = '$id' AND
			usu_email <> '$user'");
		$ex->execute();
		//print_r($ex);exit;
	}

	public function RetNiveis(){
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM niveis ");
		$ex->execute();
		return $ex;

	}

	public function Numpag_usuarios()
	{
		include "../configs/conexao.class.php";

		$porpag = 10;
		$ex = $pdo->query("SELECT count(*) as total FROM usuarios")->fetch(PDO::FETCH_OBJ);
		$numPag = ceil($ex->total / $porpag);

		return $numPag;
	}

	public function Ret_usuarios($pag)
	{
		include "../configs/conexao.class.php";

		$porpag = 10;
		$ini    = ($pag - 1) * $porpag;
		$ex = $pdo->prepare("SELECT u.*, n.* FROM usuarios u
		INNER JOIN niveis n ON n.nivel_id = u.usu_direitos
		LIMIT $ini, $porpag");
		$ex->execute();
		return $ex;
	}

	public function Ret_porLogin($usr)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM usuarios WHERE username = '$usr'");
		$ex->execute();

		while ($rs = $ex->fetch(PDO::FETCH_ASSOC)) {
			$id = $rs["usuario_id"];
		}

		return $id;
	}

	public function Ret_unico()
	{
		include "../configs/conexao.class.php";
		$id = $this->id;
		$ex = $pdo->prepare("SELECT u.*, n.* FROM usuarios u
		INNER JOIN niveis n ON u.usu_direitos = n.nivel_id WHERE u.usu_id = '$id'");
		$ex->execute();
		//print_r($ex);exit;

		return $ex;
	}

	private function Verifica_existencia()
	{
		include "../configs/conexao.class.php";
		$ex         = $pdo->prepare("SELECT email FROM usuarios WHERE email = '$this->login'");
		$ex->execute();

		//print_r($ex);exit;

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
		$desc = [];
		if ($pass < 6 || $pass > 12) {
			$desc[] = "Senha precisa ter entre 6 e 12 dígitos";
			$erros++;
		} elseif ($name > 150 || $name < 1) {
			$desc[] = "Nome inválido";
			$erros++;
		} elseif ($user > 25 || $user < 3) {
			$desc[] = "Usuário inválido";
			$erros++;
		}
		$verifica = $this->Verifica_existencia();
		if ($verifica == false) {
			$desc[] = "Login já está em uso.";
			$erros++;
		}
		if ($erros > 0) {
			return $desc;
		} else {
			return false;
		}
	}

	public function Valida_edicao()
	{

		$pass = strlen($this->senha);
		$name = strlen($this->nome);
		$user = strlen($this->login);

		$erros = 0;
		$desc =[];

		if ($pass < 6 || $pass > 32) {
			$desc[] = "Senha precisa ter entre 6 e 12 dígitos";
			$erros++;
		} elseif ($name > 150 || $name < 1) {
			$desc[] = "Nome inválido";
			$erros++;
		} elseif ($user > 25 || $user < 3) {
			$desc[] = "Usuário inválido";
			$erros++;
		}
		if ($erros > 0) {
			return $desc;
		} else {
			return true;
		}
	}

}
