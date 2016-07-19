<?php
	Class Verificalogin{


		public function validaLogin($usuario, $senha){

			$usr = $usuario;
			$sn = $senha;

			include("../configs/conexao.class.php");

			$login = $pdo->prepare("SELECT * FROM usuario WHERE usuario_login = '$usr' AND usuario_senha = '$sn' AND usuario_ativo = '1' ");
			$login->execute();


    		if($login ->rowCount() > 0){
				return true;
			}else
				return false;
		}
	}
?>
