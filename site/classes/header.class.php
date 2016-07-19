<?php
class Redirect
{

	public function PegaServer()
	{
		$urlbase = "http://dev.yousolutions.com.br:8008/sindasp/site/";
		// $urlbase = "http://localhost/YeOcDev/erpsindasp/erp/";
		// $urlbase = "http://localhost:8090/YouBR/sitesindasp/site/";
		// $urlbase = "http://localhost/projetos/YeOcDev/erpsindasp/erp/";
		return $urlbase;
	}

	public function Redir($pag)
	{
		$site = $this->PegaServer();
		header("Location: " . $site . $pag);
	}

}
