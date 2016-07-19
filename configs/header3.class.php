<?php


		class Redirect{

			public function PegaServer(){
				$urlbase = "http://dev.yousolutions.com.br:8008/sindasp/";
		  //  $urlbase = "http://localhost/YeOcDev/erpsindasp/erp/";
			//	$urlbase = "http://localhost/projetos/YeOcDev/erpsindasp/erp/";

			//	$urlbase = "http://www.yousites.com.br/";

				return $urlbase;
			}

			public function PegaSaida(){
				$urlbase = "http://dev.yousolutions.com.br:8008/sindasp/login/";
			// 	$urlbase = "http://localhost/YeOcDev/erpsindasp/login/";
			//	$urlbase = "http://localhost/projetos/YeOcDev/erpsindasp/login/";
			//	$urlbase = "http://www.yousites.com.br/login/";


				return $urlbase;
			}

			public function Directout($pag){

					$site = $this->PegaSaida();

				header("Location: ".$site.$pag);

			}

			public function Redir($pag){
				$site = $this->PegaServer();

				header("Location: ".$site.$pag);

			}


		}

?>
