<?php
        include("controletemp/topo.php");
                $cont = new Content("html/cadcategorias.html");
                $cont->ACTION = "editacategoria.php";

                if(isset($_REQUEST["id"])){
                  $id = $_REQUEST["id"];
                }else {
                  $id = 0;
                }

                include("classes/categorias.class.php");
                $categoria = new Categoria();

                $infos = $categoria->Ret_unica($id);
                foreach($infos as $inf => $in){
                  $cont->NOME = $in["categpost_nome"];
                }
                $cont->ID = $id;
                if(isset($_POST["cadastrar"])){
                    include("classes/postCategoria.class.php");

                    include("classes/editaCategoria.class.php");

                }



        include("controletemp/rodape.php");

?>
