<?php

        class Login{


            public function conectar($usr, $pass){
              include("../configs/conexao.class.php");

                $pass = md5($pass);

                $login = $pdo->prepare("SELECT * FROM usuario WHERE usuario_login = '$usr' AND usuario_senha = '$pass' AND usuario_ativo = '1'");
                $login->execute();
                if($login->rowCount()>0)
                    return TRUE;
                else
                    return FALSE;


            }




        }

?>
