<?php

        class Agenda{



            public function __construct(){

                $this->setID("");
                $this->setTitulo("");
                $this->setDataFim("");
                $this->setDataIni("");
                $this->setObs("");
                $this->setUserId("");
            }


            public function setID($id){
                $this->id = $id;
            }
            public function getID(){
               return $this->id;
            }

            public function setTitulo($titulo){
                $this->titulo = $titulo;
            }
            public function getTitulo(){
               return $this->titulo;
            }

            public function setDataIni($dataini){
                $this->dataini = $dataini;
            }
            public function getDataIni(){
               return $this->dataini;
            }

            public function setDataFim($datafim){
                $this->datafim = $datafim;
            }
            public function getDataFim(){
               return $this->datafim;
            }

            public function setObs($obs){
                $this->obs = $obs;
            }
            public function getObs(){
               return $this->obs;
            }


            public function setUserId($userid){
                $this->userid = $userid;
            }
            public function getUserId(){
               return $this->userid;
            }

            public function NovoEvento(){
              include("../configs/conexao.class.php");

              $parametros = array(":titulo"=>$this->titulo, ":dataini"=>$this->dataini,
              ":datafim"=>$this->datafim, ":obs"=>$this->obs);

              $ex = $pdo->prepare("INSERT INTO agenda (ag_titulo, ag_data_inicio, ag_data_fim,
              ag_obs) VALUES (:titulo, :dataini, :datafim, :obs)");
              $ex->execute($parametros);

            }

            public function Atualizar_Evento(){
              include("../configs/conexao.class.php");

              $parametros = array(":id"=>$this->id, ":titulo"=>$this->titulo, ":dataini"=>$this->dataini,
              ":datafim"=>$this->datafim, ":obs"=>$this->obs, ":userid"=>$this->userid);

              $ex = $pdo->prepare("UPDATE agenda SET ag_titulo = :titulo, ag_data_inicio = :dataini,
              ag_data_fim = :datafim, ag_obs = :obs WHERE id = :id AND usuario_id = :userid");
              $ex->execute($parametros);

            
            }

            public function Ret_unico($id){
              include("../configs/conexao.class.php");
              $ex = $pdo->prepare("SELECT * FROM agenda WHERE id = '$id'");
              $ex->execute();

              return $ex;
            }

            public function Excluir_evento($id){
              include("../configs/conexao.class.php");
              $ex = $pdo->prepare("DELETE FROM agenda WHERE id = '$id'");
              $ex->execute();
            }

            public function Valida_agenda(){
              include("../configs/conexao.class.php");

              $parametros = array(":titulo"=>$this->titulo,
              ":dataini"=>$this->dataini, ":datafim"=>$this->datafim);

              $ex = $pdo->prepare("SELECT * FROM agenda WHERE ag_titulo = :titulo
              AND ag_data_inicio = :dataini AND ag_data_fim = :datafim");
              $ex->execute($parametros);

              if($ex->rowCount()>0){
                return FALSE;
              }else {
                return TRUE;
              }

            }


          public function Ret_eventos($pag){
            include("../configs/conexao.class.php");
            $pag = $pag -1;
            $ex = $pdo->prepare("SELECT * FROM agenda
            ORDER BY ag_data_inicio LIMIT $pag, 20");
            $ex->execute();

            return($ex);


          }

        public function Numpag_agenda(){
          include("../configs/conexao.class.php");

          $porpag = 10;

          $ex = $pdo->query("SELECT count(*) as total FROM agenda")->fetch(PDO::FETCH_OBJ);

          $numPag = ceil($ex->total / $porpag);

          return $numPag;

        }


        }

?>
