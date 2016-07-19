<?php
include("classes/class.Email.php");

if($_REQUEST['nome'] && $_REQUEST['email'] && $_REQUEST['mensagem']){
	$mail = new Email();
	$dadosEmail = array(
		"nome"		=> $_REQUEST['nome'],
		"email"		=> $_REQUEST['email'],
		"mensagem"	=> $_REQUEST['mensagem'],
	);
	$infoEmail = array(
		"from"		=> "sindasp@sindasp.org.br",
		"from_name"	=> "Formulário de Contato",
		"to"		=> array('sindasp@sindasp.org.br'),
		"to_name"	=> 'Equipe SINDASP',
		"subject"	=> "Você acaba de receber um novo contato do site!",
	);
	try {
		$mail->novoContato($dadosEmail,$infoEmail);
		$return['code'] = "ok";
	} catch (Exception $e) {
		$return['code'] = "mail";
		$return['msg'] = "Não foi possível enviar o contato, por favor tente novamente.";
	}
	echo json_encode($return);
} else {
	$return['code'] = "vazio";
	$return['msg'] = "Por favor preencha todos os campos e tente novamente.";
	echo json_encode($return);
}

?>
