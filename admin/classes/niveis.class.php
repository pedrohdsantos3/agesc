<?php
		require_once("classes/usuario.class.php");
		$infos = new Usuario();

			$usuario = $_SESSION["user"];

			$header->USUARIO = ($infos->Nome($usuario));
			$header->NIVEL = $infos->Nivel($usuario);


?>
