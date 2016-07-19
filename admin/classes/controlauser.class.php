<?php

		include("classes/verificalogin.class.php");
		$controle = new Verificalogin();
		if(isset($_SESSION["user"]))
			$usuario = $_SESSION["user"];
		else
			$usuario = 0;

		if(isset($_SESSION["senha"]))
			$senha = $_SESSION["senha"];
		else
			$senha = 0;



		$login = $controle->validaLogin($usuario, $senha);


		if($login == FALSE) {

		  $redir->Directout("index.php");
    }
?>
