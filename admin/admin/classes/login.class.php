<?php

        class Login{


            public function conectar($usr, $pass){
              include("../configs/conexao.class.php");
                
                $pass = md5($pass);

                $login = $pdo->prepare("SELECT * FROM users WHERE usuario = '$usr' AND senha = '$pass' AND acesso = '5'");
                $login->execute();
                if($login->rowCount()>0)
                    return TRUE;
                else
                    return FALSE;


            }




        }

?>
