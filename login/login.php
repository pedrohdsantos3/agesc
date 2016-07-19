<?php
        if(isset($_POST["entrar"])){


          include("../configs/header.class.php");
          $redir = new Redirect();

                   include("classes/postLogin.php");

                   include("classes/login.class.php");
                   $login = new Login();

                   $con = $login->conectar($user, $senha);


                   if($con > 0){
                       session_start();
                       $_SESSION["user"] = $user;
                       $_SESSION["senha"] = md5($senha);

                       $redir->Redir("index.php");

                   }else {
                        $redir->Directout("index.php?e=erro");

                  }






        }
?>
