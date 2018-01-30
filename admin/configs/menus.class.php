<?php

    class MontaMenu{

      public function __construct(){

          $this->setID("");
          $this->setUser("");
        }

      public function setID($id){
          $this->id = $id;
      }
      public function getID(){
         return $this->id;
        }

        public function setUser($login){
            $this->login = $login;
        }
        public function getUser(){
           return $this->login;
          }

      public function Ret_direitos(){
          include("conexao.class.php");
          $parametro = array(":login"=> $this->login);

          $ex = $pdo->prepare("SELECT u.*, n.* FROM usuarios u
          INNER JOIN niveis n ON u.usu_direitos = n.nivel_id WHERE u.usu_email = '$this->login' ");
          $ex->execute();

          //print_r($ex);exit;

          $dir = '0';
          while($rs = $ex->fetch(PDO::FETCH_ASSOC)){
            $dir = $rs["direitos"];
          }
          return $dir;
      }

      public function Carrega_menu(){
        include("conexao.class.php");

        $user = $_SESSION["user"];
        $this->setUser($user);
        $dir = $this->Ret_direitos();

        $ex = $pdo->prepare("SELECT * FROM menus WHERE (menu_direitos & '$dir') > 0");
        $ex->execute();

        //print_r($ex);exit;

        return $ex;
      }

      public function Ret_paginas(){
        include("conexao.class.php");
        $user = $_SESSION["user"];
        $this->setUser($user);
        $dir = $this->Ret_direitos();
        $idmenu = $this->id;

        $ex = $pdo->prepare("SELECT * FROM paginas WHERE (pag_direitos & '$dir')>0
        AND pag_menu = '$idmenu'");
        $ex->execute();

        return $ex;

      }




    }


 ?>
