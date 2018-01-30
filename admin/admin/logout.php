<?php
			session_start();
			include("../configs/header.class.php");
			$redir = new Redirect();
			$_SESSION["user"] = 0;
            $redir->Directout("index.php");

	?>
