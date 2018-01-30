<?php

        class Login{

            public function __construct(){
              $this->setUser("");
              $this->setPass("");
            }

            public function setUser($user){
              $this->user = $user;
            }
            public function getUser(){
              return $this->user;
            }

            public function setPass($pass){
              $this->pass = $pass;
            }
            public function getPass(){
              return $this->pass;
            }

            public function PostLogin(){

               $__campos = array("user", "senha");

               foreach($__campos as $c){
                   $_v_=isset($_POST[$c])?$_POST[$c]:"";

                   if(is_string($_v_))
                       $_v_=trim($_v_);
                   $GLOBALS[$c]=$_v_;
               }
               unset($_v_);


            }

            public function conectar(){
              include("../configs/conexao.class.php");

                $login = $pdo->prepare("SELECT * FROM usuarios WHERE usu_email = '$this->user' AND usu_senha = '$this->pass'");
                $login->execute();
                if($login->rowCount()>0)
                    return TRUE;
                else
                    return FALSE;
            }




        }

?>
