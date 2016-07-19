<?php
class Redirect
{
	public function PegaServer()
	{
		//$urlbase = "http://dev.yousolutions.com.br:8008/sindasp/admin/";
		// $urlbase = "http://localhost:8090/YouBR/sitesindasp/admin/";
		 $urlbase = "http://agoraeuseconsagro-com-br.umbler.net/admin/";
		// $urlbase = "http://localhost/projetos/YeOcDev/sindasp/admin/";
		return $urlbase;
	}

	public function PegaSite()
	{
	//	$urlbase = "http://dev.yousolutions.com.br:8008/sindasp/site/";
		// $urlbase = "http://localhost:8090/YouBR/sitesindasp/site/";
		 $urlbase = "http://agoraeuseconsagro-com-br.umbler.net/site/";
		// $urlbase = "http://localhost/projetos/YeOcDev/sindasp/site/";
		return $urlbase;
	}

	public function PegaSaida()
	{
	//	$urlbase = "http://dev.yousolutions.com.br:8008/sindasp/login/";
		// $urlbase = "http://localhost:8090/YouBR/sitesindasp/login/";
		 $urlbase = "http://agoraeuseconsagro-com-br.umbler.net/login/";
		// $urlbase = "http://localhost/projetos/YeOcDev/sindasp/login/";
		return $urlbase;
	}

	public function site($pag)
	{
		$site = $this->PegaSite();
		header("Location: " . $site . $pag);
	}

	public function Directout($pag)
	{
		$site = $this->PegaSaida();
		header("Location: " . $site . $pag);
	}

	public function Redir($pag)
	{
		$site = $this->PegaServer();
		header("Location: " . $site . $pag);
	}

}
