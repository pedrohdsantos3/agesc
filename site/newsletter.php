<?php
// include("classes/class.Email.php");
include("classes/sitecont.class.php");
$site = new Conteudo();

if($_REQUEST['nome'] && $_REQUEST['email'] && $_REQUEST['whatsapp']){
	// $mail = new Email();
	$dadosEmail = array(
		"nome"		=> $_REQUEST['nome'],
		"email"		=> $_REQUEST['email'],
		"whatsapp"	=> $_REQUEST['whatsapp'],
	);
	// $infoEmail = array(
	// 	"from"		=> "sindasp@sindasp.org.br",
	// 	"from_name"	=> "Inscrição de Newsletter do Site",
	// 	"to"		=> array('sindasp@sindasp.org.br'),
	// 	"to_name"	=> 'Equipe SINDASP',
	// 	"subject"	=> "Você acaba de receber um novo inscrito no site!",
	// );
	if($site->validaInscrito($dadosEmail)){
		$return['code'] = "duplicado";
		$return['msg'] = "Você já inscrever-se em nosso site, Obrigado!";
	} else {
		try {
			// $mail->novoContato($dadosEmail,$infoEmail);
			$site->novoInscrito($dadosEmail);
			$return['code'] = "OK";
			$return['msg'] = "Inscrição realizada com sucesso!";
		} catch (Exception $e) {
			$return['code'] = "banco";
			$return['msg'] = "Não foi possível inscrever-se, por favor tente novamente.";
		}
	}
	echo json_encode($return);
} else {
	$return['code'] = "vazio";
	$return['msg'] = "Por favor preencha todos os campos e tente novamente.";
	echo json_encode($return);
}

?>
