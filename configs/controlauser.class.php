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

		$protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
		$site = $protocol. $_SERVER['SERVER_NAME'] .'/';

		if($login == FALSE)
			header("Location: ".$site."/site/login");

?>
