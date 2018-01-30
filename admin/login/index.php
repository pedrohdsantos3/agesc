<?php
    require_once("controletemp/topo.php");
    include("../configs/header.class.php");
    $redir = new Redirect();
         
         
         
         $cont->MSG = "Admin Login";

         if(isset($_POST["entrar"])){
                    include("classes/login.class.php");
                    $login = new Login();
                    $login->PostLogin();
                    $login->setUser($user);
                    $login->setPass(md5($senha));
                    $con = $login->conectar();

                    if($con > 0){
                        session_start();
                        $_SESSION["user"] = $user;
                        $_SESSION["senha"] = md5($senha);

                        $redir->Redir("index.php");

                    }else {
                      $cont->MSG = "Usuário ou Senha inválidos.";

                   }
         }
         

    include("controletemp/rodape.php");
?>
