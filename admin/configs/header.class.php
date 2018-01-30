<?php


		class Redirect{

			public function PegaServer(){
				$urlbase = "http://localhost/radynSite/admin/admin/";

				return $urlbase;
			}

			public function PegaSite(){
				$urlbase = "http://localhost/radynSite/admin/site/";

				return $urlbase;
			}

			public function PegaSaida(){
				$urlbase = "http://localhost/radynSite/admin/login/";


				return $urlbase;
			}

			public function site($pag){

					$site = $this->PegaSite();

				header("Location: ".$site.$pag);

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
