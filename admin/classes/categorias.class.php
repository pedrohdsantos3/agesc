<?php

        class Categoria{



            public function __construct(){


                $this->setID("");
                $this->setAtivo("");
                $this->setNome("");
            }


            public function setID($id){
                $this->id = $id;
            }
            public function getID(){
               return $this->id;
            }

            public function setAtivo($ativo){
                $this->ativo = $ativo;
            }
            public function getAtivo(){
               return $this->ativo;
            }

            public function setNome($nome){
                $this->nome = $nome;
            }
            public function getNome(){
               return $this->nome;
            }



          public function Cad_categoria(){
            include("../configs/conexao.class.php");
              include("classes/uniqueid.class.php");
              $uniqueid = new Uniqueid();
              $this->id = $uniqueid->gera_id();

              $parametros = array(":id"=>$this->id,
              ":ativo"=>$this->ativo, ":nome"=>$this->nome);

              $ex = $pdo->prepare("INSERT INTO categ_post
              (categpost_id, categpost_nome, categpost_ativo)
              VALUES (:id, :nome, :ativo)");

              $ex->execute($parametros);


          }
          public function Editar_categoria(){
            include("../configs/conexao.class.php");

            $parametros = array(":id"=>$this->id,":nome"=>$this->nome);

            $ex = $pdo->prepare("UPDATE categ_post SET categpost_nome = :nome
            WHERE categpost_id = :id");
            $ex->execute($parametros);


          }

          public function Inativar_categoria($id){
            include("../configs/conexao.class.php");
            $ctl = $pdo->prepare("SELECT categpost_ativo FROM categ_post WHERE categpost_id = '$id'");
            $ctl->execute();

            while($rs = $ctl->fetch(PDO::FETCH_ASSOC)){
              if($rs["categpost_ativo"] == 1){
                $act = 0;
              }else {
                $act = 1;
              }
            }

            $ex = $pdo->prepare("UPDATE categ_post SET categpost_ativo = '$act' WHERE categpost_id = '$id'");
            $ex->execute();

          }

            public function Ret_categorias($pag){
              include("../configs/conexao.class.php");
              $porpag = 10;
              $ini = ($pag-1)*$porpag;
              $ex = $pdo->prepare("SELECT * FROM categ_post LIMIT $ini, $porpag");
              $ex->execute();

              return $ex;
            }

            public function Ret_nome_id($id){
              include("../configs/conexao.class.php");

                $ex = $pdo->prepare("SELECT categpost_id, categpost_nome FROM categ_post
                WHERE categpost_id = '$id'");
                $ex->execute();


                return $ex;
            }

            public function Ret_todas(){
              include("../configs/conexao.class.php");

              $ex = $pdo->prepare("SELECT * FROM categ_post WHERE categpost_ativo = '1'");
              $ex->execute();


              return $ex;
            }

            public function Ret_unica($id){
              include("../configs/conexao.class.php");

              $ex = $pdo->prepare("SELECT * FROM categ_post WHERE categpost_id = '$id'");
              $ex->execute();


              return $ex;
            }

            public function Numpag_categ(){
              include("../configs/conexao.class.php");
              $porpag = 10;

    					$ex = $pdo->query("SELECT count(*) as total FROM categ_post")->fetch(PDO::FETCH_OBJ);

    					$numPag = ceil($ex->total / $porpag);

    					return $numPag;
            }

            public function Verifica_existencia(){
              include("../configs/conexao.class.php");
              $parametros = array(":nome"=>$this->nome);
              $ex = $pdo->prepare("SELECT categpost_nome FROM categ_post WHERE categpost_nome = :nome");
              $ex->execute($parametros);

              if($ex->rowCount() > 0){
                return FALSE;
              }else {
                return TRUE;
              }

            }

            public function Valida_categoria(){

              $name = strlen($this->nome);

              $erros = 0;
              if($name>50 || $name<1){
                $erros++;
              }
              $verifica = $this->Verifica_existencia();
              if($verifica == FALSE){
                $erros++;
              }
              if($erros > 0){
                return FALSE;
              }else {
                return TRUE;
              }



            }
            public function Valida_edicao(){

              $name = strlen($this->nome);
              $erros = 0;
              if($name>150 || $name<1){
                $erros++;
              }
              if($erros > 0){
                return FALSE;
              }else {
                return TRUE;
              }



            }

        }

?>
