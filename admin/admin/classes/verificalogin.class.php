<?php
	Class Verificalogin{


		public function validaLogin($usuario, $senha){

			$usr = $usuario;
			$sn = $senha;

			include("../configs/conexao.class.php");

			$login = $pdo->prepare("SELECT * FROM usuarios WHERE usu_email = '$usr' AND usu_senha = '$sn'");
			$login->execute();


    		if($login ->rowCount() > 0){
				return true;
			}else
				return false;
		}


		public function valida_dir($pagina, $usuario){
			include("../configs/conexao.class.php");

			$dir = $this->Ret_dir($usuario);

			//echo $dir;exit;

			$ex = $pdo->prepare("SELECT * FROM paginas WHERE pag_arquivo = '$pagina'
			AND (pag_direitos & '$dir')>0 ");
			//print_r($ex);exit;
			$ex->execute();

			if($ex->rowCount()> 0){
				return TRUE;
			}else {
				return FALSE;
			}

		}

			public function DireitoEdicao( $pagina, $usuario){
				include "../configs/conexao.class.php";

				$ex = $pdo->prepare("SELECT p.*, u.*, n.* FROM usuarios u
				INNER JOIN paginas p ON p.pag_arquivo = '$pagina'
				INNER JOIN niveis n ON u.usu_direitos = n.nivel_id
				WHERE u.usu_email = '$usuario' AND (n.direitos & p.pag_edicao)>0 ");
				$ex->execute();
				//print_r($ex);exit;
				if($ex->rowCount()>0){
					return TRUE;
				}else{
					return FALSE;
				}
			}

		public function RetIdUsuario($usuario){
			include("../configs/conexao.class.php");

			$ex = $pdo->prepare("SELECT * FROM usuarios WHERE usu_email = '$usuario'");
			$ex->execute();

			$rs = $ex->fetch(PDO::FETCH_ASSOC);
			$id = $rs["usu_id"];
			return $id;

		}

		public function Ret_dir($usuario){
			include("../configs/conexao.class.php");


			$ex = $pdo->prepare("SELECT u.*, n.* FROM usuarios u
			INNER JOIN niveis n ON u.usu_direitos = n.nivel_id
			WHERE u.usu_email = '$usuario'");
			$ex->execute();

			$dir = '0';
			while($rs = $ex->fetch(PDO::FETCH_ASSOC)){
				$dir = $rs["direitos"];
			}

			return $dir;
		}
	}
?>
