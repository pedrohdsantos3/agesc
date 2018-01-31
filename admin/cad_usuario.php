<?php
include("controletemp/topo.php");
$cont->addFile("CONTEUDO","html/editausuario.html");
include("classes/usuarios.class.php");
$usuarios = new Usuario();
// -- \/ Definindo qual será a ação do formulário HTML.
$cont->ACTION = "cad_usuario.php";

// -- Carregando os níveis possíveis para o administrador cadastrar os usuários.

if(isset($_GET["id"])){
  $id = $_GET["id"];
  $usuarios->setId($id);
  $infoUser = $usuarios->Ret_unico();
  foreach($infoUser as $info =>$i){
    $cont->ID = $id;
    $cont->NOME = $i["usu_nome"];
    $cont->USU_NIVELED = $i["nivel_nome"];
    $cont->IDNIVELED = $i["nivel_id"];
    $cont->block("BLOCK_EDITANIVEL");

  }
}

//\\ Informações dos usuários que estiverem sendo editados.

//\\// Níveis possíveis para os usuários do sistema.
$niveis = $usuarios->RetNiveis();
while($lista = $niveis->fetch(PDO::FETCH_ASSOC)){
    $cont->IDNIVEL = $lista["nivel_id"];
    $cont->USU_NIVEL = utf8_encode($lista["nivel_nome"]);
    $cont->block("BLOCK_NIVEIS");
}

//\\ Chamada dos metodos necessários a gravação/atualização do usuário.
if(isset($_POST["cadastrar"])){
  $usuarios->PostUsuario();

  $usuarios->setID($id);
  $usuarios->setNome(utf8_decode($nome));
  $usuarios->setLogin($email);
  $usuarios->setSenha($senha);
  $usuarios->setNivel($nivel);

  $cadastro = $usuarios->Cad_usuario();
  //print_r($cadastro);exit;
  if($cadastro == FALSE){
    $redir->Redir("lista_usuarios.php?c=sucesso");
//    $cont->block("BLOCK_MSG");
  }else{
    for($i=0;$i<count($cadastro);$i++){
      $cont->MSG = $cadastro[$i];
      $cont->block("BLOCK_MSG");
    }
  }

}


include("controletemp/rodape.php");
?>
