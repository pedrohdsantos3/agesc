<?php
	Class Verificalogin{


		public function validaLogin($usuario, $senha){

			$usr = $usuario;
			$sn = md5($senha);

			include("../configs/conexao.class.php");
			
			$login = $pdo->prepare("SELECT * FROM login WHERE usuario = '$usr' AND senha = '$sn' AND acesso = '5' ");
			$login->execute();
			if($login ->rowCount()){
				return true;
			}else
				return false;
		}
	}
?>
