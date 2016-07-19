<?php

class Noticias
{

	public function __construct()
	{
		$this->setID("");
		$this->setUserId("");
		$this->setCatId("");
		$this->setTipoPost("");
		$this->setData("");
		$this->setTitulo("");
		$this->setAnonimo("");
		$this->setSubt("");
		$this->setTexto("");
		$this->setDestaque("");
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

	public function setCatId($catid)
	{
		$this->catid = $catid;
	}
	public function getCatId()
	{
		return $this->catid;
	}

	public function setTipoPost($tpost)
	{
		$this->tpost = $tpost;
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

	public function setAnonimo($anonimo)
	{
		$this->anonimo = $anonimo;
	}
	public function getAnonimo()
	{
		return $this->anonimo;
	}

	public function setSubt($subt)
	{
		$this->subtitulo = $subt;
	}
	public function getSubt()
	{
		return $this->subtitulo;
	}

	public function setTexto($texto)
	{
		$this->texto = $texto;
	}
	public function getTexto()
	{
		return $this->texto;
	}

	public function setDestaque($destq)
	{
		$this->destaque = $destq;
	}
	public function getDestaque()
	{
		return $this->destaque;
	}

	public function setAtivo($ativo)
	{
		$this->ativo = $ativo;
	}
	public function getAtivo()
	{
		return $this->ativo;
	}

	public function Cad_noticia()
	{
		include "../configs/conexao.class.php";

		include "classes/uniqueid.class.php";
		$uniqueid = new Uniqueid();
		$this->id = $uniqueid->gera_id();

		include "classes/datas.class.php";
		$data = new Datas();
		$this->data = $data->ConvertePb($this->data);

		$parametros = array(
			":id"		=> $this->id,
			":userid"	=> $this->userid,
			":catid"	=> $this->catid,
			":tpost"	=> $this->tpost,
			":data"		=> $this->data,
			":titulo"	=> $this->titulo,
			":anonimo"	=> $this->anonimo,
			":subt"		=> $this->subtitulo,
			":texto"	=> $this->texto,
			":destaque"	=> $this->destaque,
			":ativo"	=> $this->ativo
		);

		$ex = $pdo->prepare("INSERT INTO post
			  (post_id, usuario_id, tipopost_id, categoria_id, post_data, post_titulo,
			  post_subtitulo, post_texto, post_destaque, post_ativo, post_anonimo)
			  VALUES (:id, :userid, :tpost, :catid, :data, :titulo, :subt,
			  :texto, :destaque, :ativo, :anonimo)");
		$ex->execute($parametros);

		return $this->id;
	}

		public function Repost($idpost){
			include("../configs/conexao.class.php");
			include "classes/uniqueid.class.php";
			$uniqueid = new Uniqueid();
			$this->id = $uniqueid->gera_id();

			$post = $pdo->prepare("SELECT p.*, i.* FROM post p LEFT JOIN imagem i ON p.post_id = i.post_id WHERE p.post_id = '$idpost'");
			$post->execute();
			$rs = $post->fetch(PDO::FETCH_ASSOC);
			$parametros = array(
					":id"		=> $this->id,
					":userid"	=> $rs["usuario_id"],
					":catid"	=> $rs["categoria_id"],
					":tpost"	=> $rs["tipopost_id"],
					":data"		=> date("Y-m-d H:m:i"),
					":titulo"	=> $rs["post_titulo"],
					":anonimo"	=> $rs["post_anonimo"],
					":subt"		=> $rs["post_subtitulo"],
					":texto"	=> $rs["post_texto"],
					":destaque"	=> $rs["post_destaque"],
					":ativo"	=> $rs["post_ativo"]
				);
			$img = array(":post_id" => $this->id,
			":imagem_title" => $rs["imagem_title"],
			":imagem_alt"=> $rs["imagem_alt"],
			":imagem_link"=> $rs["imagem_link"]);

				$duplica = $pdo->prepare("INSERT INTO post
					  (post_id, usuario_id, tipopost_id, categoria_id, post_data, post_titulo,
					  post_subtitulo, post_texto, post_destaque, post_ativo, post_anonimo)
					  VALUES (:id, :userid, :tpost, :catid, :data, :titulo, :subt,
					  :texto, :destaque, :ativo, :anonimo)");
				$duplica->execute($parametros);

				$imagem = $pdo->prepare("INSERT INTO imagem (post_id, imagem_title, imagem_alt, imagem_link)
				VALUES (:post_id, :imagem_title, :imagem_alt, :imagem_link)");
				$imagem->execute($img);


		}

	public function Editar_noticia()
	{
		include "../configs/conexao.class.php";

		include "classes/datas.class.php";
		$data = new Datas();
		$this->data = $data->ConvertePb($this->data);

		$parametros = array(
			":id"		=> $this->id,
			":catid"	=> $this->catid,
			":tpost"	=> $this->tpost,
			":data"		=> $this->data,
			":titulo"	=> $this->titulo,
			":anonimo"	=> $this->anonimo,
			":subt"		=> $this->subtitulo,
			":texto"	=> $this->texto,
			":destaque"	=> $this->destaque
		);

		$ex = $pdo->prepare("UPDATE post
			SET categoria_id = :catid, tipopost_id = :tpost, post_data = :data, post_titulo = :titulo,
			post_subtitulo = :subt, post_texto = :texto, post_destaque = :destaque, post_anonimo = :anonimo
			WHERE post_id = :id");
		$ex->execute($parametros);

		return $this->id;
	}


	public function Inativar_post($id)
	{
		include "../configs/conexao.class.php";

		$ctl = $pdo->prepare("SELECT post_ativo FROM post WHERE post_id = '$id'");
		$ctl->execute();

		while ($rs = $ctl->fetch(PDO::FETCH_ASSOC)) {
			if ($rs["post_ativo"] == 1) {
				$act = 0;
			} else {
				$act = 1;
			}
		}

		$ex = $pdo->prepare("UPDATE post SET post_ativo = '$act' WHERE post_id = '$id'");
		$ex->execute();
	}

	public function Ret_noticias($pag)
	{
		include "../configs/conexao.class.php";

		$porpag = 10;
		$ini    = ($pag - 1) * $porpag;
		$ex     = $pdo->prepare("SELECT * FROM post p INNER JOIN usuario u on u.usuario_id = p.usuario_id
				ORDER BY p.post_data DESC LIMIT $ini, $porpag ");
		$ex->execute();

		return $ex;
	}

	public function Ret_unica($id)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM post p, tipo_post t, imagem i
			WHERE p.post_id = i.post_id
			AND p.tipopost_id = t.tipopost_id
			AND p.post_id = '$id'");
		$ex->execute();

		return $ex;
	}

	public function Numpag_post()
	{
		include "../configs/conexao.class.php";
		$porpag = 10;

		$ex = $pdo->query("SELECT count(*) as total FROM post")->fetch(PDO::FETCH_OBJ);

		$numPag = ceil($ex->total / $porpag);

		return $numPag;
	}

	public function Verifica_existencia()
	{
		include "../configs/conexao.class.php";

		$parametros = array(":titulo" => $this->titulo);
		$ex         = $pdo->prepare("SELECT post_titulo FROM post WHERE post_titulo = :titulo");
		$ex->execute($parametros);

		if ($ex->rowCount() > 0) {
			return false;
		} else {
			return true;
		}
	}

	public function Valida_noticia()
	{
		$erros	= array();
		$titulo	= strlen($this->titulo);
		$subt	= strlen($this->subtitulo);
		$txt	= strlen($this->texto);
		$erro	= 0;
		$i		= 0;

		$erros = 0;
		if ($titulo > 200 || $titulo < 1) {
			$erros[$i++] = "T&iacute;tulo deve ter no m&aacute;ximo 200 car&aacute;cteres.";
			$erros++;
		}
		if ($subt > 400 || $subt < 1) {
			$erros[$i++] = "Sub-T&iacute;tulo deve ter no m&aacute;ximo 400 car&aacute;cteres.";
			$erros++;
		}
		if ($txt < 1) {
			$erros[$i++] = "O Campo Conte&uacute;do da Publica&ccedil;&atilde;o deve ser preenchido e &eacute; obrigat&oacute;rio.";
			$erros++;
		}
		// $verifica = $this->Verifica_existencia();
		// if ($verifica == false) {
		// 	$erros[$i++] = "J&aacute; existe uma Publica&ccedil;&atilde;o com esse t&iacute;tulo.";
		// 	$erros++;
		// }

		if ($erro == 0) {
		    return true;
		} else {
		    return $erros;
		}
	}

	public function Valida_edicao()
	{
		$titulo	= strlen($this->titulo);
		$subt	= strlen($this->subtitulo);
		$txt	= strlen($this->texto);

		$erros = 0;
		if ($titulo > 200 || $titulo < 1) {
			$erros++;
		}
		if ($subt > 400 || $subt < 1) {
			$erros++;
		}
		if ($txt < 1) {
			$erros++;
		}

		if ($erros > 0) {
			return false;
		} else {
			return true;
		}
	}

}
