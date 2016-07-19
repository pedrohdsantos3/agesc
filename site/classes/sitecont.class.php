<?php
class Conteudo
{

	public function Ret_destaques()
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM post p
			INNER JOIN imagem img ON p.post_id = img.post_id
			WHERE p.post_destaque = 1
			AND p.post_ativo =1
			AND p.post_data <NOW()
			ORDER BY p.post_data DESC
			LIMIT 6");
		$ex->execute();

		return $ex;
	}

	public function Ret_noticia_Bgrande()
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM post p
			INNER JOIN imagem img ON p.post_id = img.post_id
			WHERE p.post_ativo =1
			AND p.tipopost_id !=2
			AND p.post_data <NOW()
			ORDER BY p.post_data DESC
			LIMIT 10");
		$ex->execute();

		return $ex;
	}

	public function Numpag_posts($id)
	{
		include "../configs/conexao.class.php";

		$porpag = 10;
		$ex = $pdo->query("SELECT count(*) as total FROM post
			WHERE tipopost_id = '$id'")->fetch(PDO::FETCH_OBJ);
		$numPag = ceil($ex->total / $porpag);

		return $numPag;
	}

	public function Ret_noticia_Bsmall()
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM post p
			INNER JOIN imagem img ON p.post_id = img.post_id
			WHERE p.post_ativo = 1
			AND p.tipopost_id != 2
			AND p.post_data <NOW()
			ORDER BY p.post_data DESC
			LIMIT 1, 5");
		$ex->execute();
		// print_r($ex);
		// exit;
		return $ex;
	}

	public function Ret_artigos()
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM post p
			INNER JOIN imagem img ON p.post_id = img.post_id
			WHERE p.tipopost_id = 3
			AND p.post_data <NOW()
			AND p.post_ativo = 1
			ORDER BY p.post_data DESC
			LIMIT 9");
		$ex->execute();

		return $ex;
	}

	public function Ret_relacionadas()
	{
		include "../configs/conexao.class.php";

	/*	$ex = $pdo->prepare("SELECT * FROM post p
			INNER JOIN imagem img ON p.post_id = img.post_id
			WHERE p.tipopost_id = 2
			AND p.post_ativo = 1
			ORDER BY p.post_data DESC
			LIMIT 9");
		$ex->execute();*/

		$ex = $pdo->prepare("SELECT * FROM post
			WHERE tipopost_id = 2
			AND post_ativo = 1
			AND post_data <NOW()
			ORDER BY post_data DESC
			LIMIT 12");
		$ex->execute();

		return $ex;
	}

	public function Ret_post($id_post)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT p.*, i.imagem_link, u.* FROM usuario u, post p
		LEFT JOIN imagem i
		ON p.post_id = i.post_id WHERE p.post_id = '$id_post'
		AND p.post_data <NOW()
		AND p.post_ativo = 1 AND p.usuario_id = u.usuario_id");
		$ex->execute();

		return $ex;
	}

	public function Ret_postRelacionadas($id_post)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM post p , usuario u
			WHERE p.post_id = '$id_post'
			AND p.post_ativo = 1
			AND p.post_data <NOW()
			AND p.usuario_id = u.usuario_id");
		$ex->execute();

		return $ex;
	}

	public function Ret_menuPrincipal()
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM paginas WHERE pag_menu_principal = 1 AND pag_status = 1");
		$ex->execute();

		return $ex;
	}

	public function Ret_pagTitulo($htmlP)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM paginas WHERE pag_link = '$htmlP'");
		$ex->execute();
		$titulo = "";
		while ($rs = $ex->fetch(PDO::FETCH_ASSOC)) {
			$titulo = $rs["pag_titulo"];
		}

		return $titulo;
	}

	public function Mais_lidas($id_post)
	{
		include "../configs/conexao.class.php";

		$visu = 0;
		$ex   = $pdo->prepare("SELECT post_id, post_visualizacoes
			FROM post
			WHERE post_id = '$id_post'");
		$ex->execute();
		while ($v = $ex->fetch(PDO::FETCH_ASSOC)) {
			$visu   = $v["post_visualizacoes"];
			$postid = $v["post_id"];
		}
		$visu = $visu + 1;
		$at   = $pdo->prepare("UPDATE post SET post_visualizacoes = '$visu'
			WHERE post_id = '$postid'");
		$at->execute();

		return $visu;
	}

	public function Ret_maislidas()
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM post p
			INNER JOIN imagem i
			ON p.post_id = i.post_id
			WHERE p.post_ativo = 1
			ORDER BY post_visualizacoes DESC
			LIMIT 4");
		$ex->execute();
		//print_r($ex);
		//exit;

		return $ex;
	}

	public function Ret_portipo($id_tipo, $pag)
	{
		include "../configs/conexao.class.php";

		$porpag = 10;
		$ini    = ($pag - 1) * $porpag;
		$ex   = $pdo->prepare("SELECT * FROM post p, imagem i
			WHERE p.post_id = i.post_id
			AND p.tipopost_id = '$id_tipo'
			AND p.post_data <NOW()
			ORDER BY p.post_data DESC
			LIMIT $ini, $porpag ");
		$ex->execute();

		return $ex;
	}

	public function Ret_portipoRelacionadasG($id_tipo, $pag)
	{
		include "../configs/conexao.class.php";

		$porpag = 10;
		$ini    = ($pag - 1) * $porpag;
		$ex   = $pdo->prepare("SELECT * FROM post WHERE tipopost_id = '$id_tipo'
			AND post_data < NOW() AND post_ativo != 0 ORDER BY post_data DESC LIMIT $ini, $porpag");
		$ex->execute();



		return $ex;
	}

	public function Total_Ret_portipo($id_tipo)
	{
		include "../configs/conexao.class.php";

		$ex   = $pdo->query("SELECT count(*) as total FROM post p, imagem i
			WHERE p.post_id = i.post_id
			AND p.tipopost_id = '$id_tipo'
			ORDER BY p.post_data DESC")->fetch(PDO::FETCH_OBJ);

		return $ex->total;
	}

	public function Ret_totalPtipo($id_tipo)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM post p, imagem i
			WHERE p.post_id = i.post_id
			AND p.tipopost_id = '$id_tipo'
			ORDER BY post_data DESC
			LIMIT 10 ");
		$ex->execute();

		return $ex;
	}

	public function searchMultiQuery($keywords, $andOperator=true)
	{
		$keywords=preg_replace('/[\x00-\x1F\x80-\xFF]/', '_',$keywords);
		$keywords=str_replace("__","_",$keywords);

		$campos=array("p.post_titulo", "p.post_texto", "p.post_subtitulo");
		$keyword_tokens=preg_split('/\W/', $keywords, 0, PREG_SPLIT_NO_EMPTY);

		$operator=$andOperator?'AND':'OR';

		$result = array();
		$whereClause = "";
		foreach($keyword_tokens as $key =>$k){
			foreach($campos as $c) {
				if ($whereClause>"")
					$whereClause.=" $operator ";
				$whereClause.=" $c LIKE '%$k%' ";
			}
		}
		if ($whereClause=="")
			$whereClause="true=false";

		return $whereClause;
	}

	public function Ret_pesquisa($keywords, $pag)
	{
		include "../configs/conexao.class.php";

		$porpag = 10;
		$ini = ($pag-1)*$porpag;
		$sql = $this->searchMultiQuery($keywords);
		$sql = "SELECT p.*, i.imagem_link
			FROM post p
			LEFT JOIN imagem i ON p.post_id = i.post_id
			WHERE $sql LIMIT $ini, $porpag
		";
		$ex = $pdo->prepare($sql);
		$ex->execute();

		return $ex;
	}

	public function Total_Ret_pesquisa($keywords)
	{
		include "../configs/conexao.class.php";

		$sql = $this->searchMultiQuery($keywords);
		$ex  = $pdo->query("
			SELECT count(*) as total
			FROM post p
			LEFT JOIN imagem i ON p.post_id = i.post_id
			WHERE $sql
		")->fetch(PDO::FETCH_OBJ);
		return $ex->total;
	}

	public function Ret_eventosAgenda()
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM agenda ORDER BY ag_data_inicio ASC");
		$ex->execute();

		return $ex;
	}

	public function Ret_enquete()
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM enquete e
			WHERE e.enq_ativo = 1
			ORDER BY e.enq_data DESC");
		$ex->execute();

		return $ex;
	}

	public function Ret_ienquete($enqueteID)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM itens_enquete ie
			WHERE ie.enq_id = $enqueteID
			ORDER BY ie.enq_id DESC");
		$ex->execute();

		return $ex;
	}

	public function Count_ienquete($enqueteID)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT count(ie_id) FROM itens_enquete WHERE enq_id = $enqueteID");
		$ex->execute();

		return $ex;
	}

	public function Grava_Votacao($id_poll,$id_ipoll)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("UPDATE itens_enquete
			SET ie_votos = ie_votos+1
			WHERE enq_id = '$id_poll'
			AND ie_id = '$id_ipoll'");
		$ex->execute();

	}

	public function novoInscrito($dadosNewsletter)
	{
		include "../configs/conexao.class.php";

		$parametros = array(
			":nome"		=> $dadosNewsletter['nome'],
			":email"	=> $dadosNewsletter['email'],
			":whatsapp"	=> $dadosNewsletter['whatsapp']
		);

		$ex = $pdo->prepare("INSERT INTO `newsletter` (nome, email, whatsapp) VALUES (:nome, :email, :whatsapp)");
		$ex->execute($parametros);

	}

	public function validaInscrito($dadosNewsletter)
	{
		include "../configs/conexao.class.php";

		$ex = $pdo->prepare("SELECT * FROM newsletter
			WHERE email = '".$dadosNewsletter['email']."' OR whatsapp = '".$dadosNewsletter['whatsapp']."';");
		$ex->execute();

		if($ex ->rowCount())
			return true;
		else
			return false;
	}

}
