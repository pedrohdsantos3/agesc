<?php

			session_start();
			include("../configs/header.class.php");
			$redir = new Redirect();
			$_SESSION["user"] = NULL;
            $redir->Directout("index.php");

	?>
