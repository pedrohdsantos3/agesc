<?php
		include("classes/usuarios.class.php");
		$infos = new Usuarios();
		
			$usuario = $_SESSION["user"];
			
			$menur->USUARIO = $infos->Nome($usuario);
			$menur->NIVEL = $infos->Nivel($usuario);
			
	
?>