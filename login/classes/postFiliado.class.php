<?php
		
		$__campos = array("nome", "rg", "cpf", "dtnasc", "telr", "email",
		"cel", "outrotel", "sexo", "estcivil", "superior", "cep", "cidade",
		"bairro", "rua", "num", "comp", "penitenciaria", "cargo", "dtadmis",
		"matricula", "nomepai", "nomemae", "nome_dep", "dtnasc_dep", "agencia",
		"conta", "banco", "facebook", "whatsapp", "telrecados" );
											
									
		foreach($__campos as $c){
			$_v_=isset($_POST[$c])?$_POST[$c]:"";
			
			if(is_string($_v_))
				$_v_=trim($_v_);
			$GLOBALS[$c]=$_v_;
			
		}							
		
		unset($_v_);								
										
										
									
										
											
									
		
?>