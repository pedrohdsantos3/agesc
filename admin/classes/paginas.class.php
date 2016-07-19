<?php

class Pagina
{

	public function __construct()
	{

		$this->setID("");
		$this->setUserId("");
		$this->setTitulo("");
		$this->setLink("");
		$this->setConteudo("");
		$this->setMenu("");
		$this->setData("");
		$this->setAtivo("");
	}

	public function setID($id)
	{
		$this->id = $id;
	}
	public function getID()
	{
		return $this->id;
	}

	public function setUserId($userid)
	{
		$this->userid = $userid;
	}
	public function getUserId()
	{
		return $this->userid;
	}

	public function setData($data)
	{
		$this->data = $data;
	}
	public function getData()
	{
		return $this->data;
	}

	public function setTitulo($titulo)
	{
		$this->titulo = $titulo;
	}
	public function getTitulo()
	{
		return $this->titulo;
	}

	public function setLink($link)
	{
		$this->link = $link;
	}
	public function getLink()
	{
		return $this->link;
	}

	public function setConteudo($conteudo)
	{
		$this->conteudo = $conteudo;
	}
	public function getConteudo()
	{
		return $this->conteudo;
	}

	public function setMenu($menu)
	{
		$this->menu = $menu;
	}
	public function getMenu()
	{
		return $this->menu;
	}

	public function setAtivo($ativo)
	{
		$this->ativo = $ativo;
	}
	public function getAtivo()
	{
		return $this->ativo;
	}

	public function Cad_pagina()
	{
		include "../configs/conexao.class.php";
		include "classes/uniqueid.class.php";
		$uniqueid    = new Uniqueid();
		$this->id    = $uniqueid->gera_id();
		$this->link  = strtolower(str_replace(" ", "-", $this->titulo));
		$this->ativo = 1;
		$parametros  = array(
			":id"		=> $this->id,
			":titulo"	=> $this->titulo,
			":data"		=> $this->data,
			":autor"	=> $this->userid,
			":link"		=> $this->link,
			":ativo"	=> $this->ativo,
			":menup"	=> $this->menu,
		);

		$ex = $pdo->prepare("INSERT INTO paginas
			(pag_id, usuario_id, pag_titulo, pag_status, pag_data, pag_link, pag_menu_principal)
			VALUES (:id, :autor, :titulo, :ativo, :data, :link, :menup)");
		$ex->execute($parametros);

		return $this->id;
	}

	public function Cria_html()
	{

		$dir = __DIR__ . "/../../site/html/paginas";
		if (!is_dir($dir))
			if (!mkdir($dir, 0777, true))
				die("A pasta '$dir' não pode ser criada com os direitos apropriados");

		if (!is_writable($dir))
			if (!chmod($dir, 0777))
				die("Os direitos da pasta '$dir' não podem ser alterados");

		$nomeArquivo = "$dir/p_" . $this->link . ".html";
		file_put_contents($nomeArquivo, $this->conteudo);
	}

	public function Ret_paginas($pag)
	{
		include "../configs/conexao.class.php";
		$porpag = 10;
		$ini    = ($pag - 1) * $porpag;
		$ex     = $pdo->prepare("SELECT * FROM paginas p INNER JOIN usuario u ON p.usuario_id = u.usuario_id LIMIT $ini, 10");
		$ex->execute();

		return $ex;
	}

	public function Numpag_post()
	{
		include "../configs/conexao.class.php";
		$porpag = 10;

		$ex = $pdo->query("SELECT count(*) as total FROM paginas")->fetch(PDO::FETCH_OBJ);

		$numPag = ceil($ex->total / $porpag);

		return $numPag;
	}

	public function Apaga_pagina($idP, $nomeP)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("DELETE FROM paginas WHERE pag_id = '$idP'");
		$ex->execute();

		$nomeP   = str_replace(" ", "-", $nomeP);
		$caminho = "../site/html/paginas/" . $nomeP;
		$apagar  = false;
		if (is_file($caminho)) {
			$apagar = unlink($caminho);
		}
		return $apagar;
	}

	public function Ver_existencia()
	{
		include "../configs/conexao.class.php";
		$titulo = $this->titulo;
		$ex     = $pdo->prepare("SELECT * FROM paginas WHERE pag_titulo = '$titulo'");
		$ex->execute();

		if ($ex->rowCount() > 0) {
			return false;
		} else {
			return true;
		}

	}

}
