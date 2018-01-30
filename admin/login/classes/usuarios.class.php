<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 *
 * @author Pedro Henrique - pedrohdsantos3@gmail.com
 */

class Usuarios {
    //put your code here


    public function __construct(){
        $this->setId("");
        $this->setNome("");
        $this->setSenha("");


    }
    public function setId($id){
        $this->id = $id;
    }
    public function getId(){
        return $this->id;
    }


    public function setNome($nome){
        $this->nome = $nome;
    }
    public function getNome(){
       return $this->nome;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }
    public function getSenha(){
        return $this->senha;
    }

    public function Nome($usuario){
      include("../configs/conexao.class.php");

            $ex = $pdo->prepare("SELECT nome FROM login WHERE usuario = '$usuario'");
            $ex->execute();

            while($rs = $ex->fetch(PDO::FETCH_ASSOC)){

                $nome = $rs["nome"];
            }

            return $nome;


    }

    public function Nivel($usuario){
      include("../configs/conexao.class.php");
        
            $ex = $pdo->prepare("SELECT acesso FROM login WHERE usuario = '$usuario'");
            $ex->execute();

            while($rs = $ex->fetch(PDO::FETCH_ASSOC)){
                $nivel = $rs["acesso"];
                if($nivel < 3)
                    $func = "Operador";
                elseif($nivel >= 3)
                    $func = "Administrador";

            }

            return $func;
    }





}

?>
