<?php
require 'PHPMailer/PHPMailerAutoload.php';

class Email {

	private $_arquivo;

	const PHPMAILER_SMTPAUTH		= true;							// turn on SMTP authentication
	const PHPMAILER_SMTPSECURE		= "tls";						// Enable TLS encryption, `ssl` also accepted

	const PHPMAILER_HOST			= "server11.srvlinux.info";		// specify main and backup server
	const PHPMAILER_USERNAME		= "contato@sindasp.org.br";		// SMTP username
	const PHPMAILER_PASSWORD		= "s91635304";					// SMTP password
	const PHPMAILER_PORT			= 465;							// TCP port to connect to

	const PHPMAILER_HOST2			= "mail.sindasp.org.br";		// specify main and backup server
	const PHPMAILER_USERNAME2		= "contato@sindasp.org.br";		// SMTP username
	const PHPMAILER_PASSWORD2		= "s91635304";					// SMTP password
	const PHPMAILER_PORT2			= 587;							// TCP port to connect to

	const EMAIL_NOVO_CONTATO		= "novoContato.txt";

	private function varredura($dados) {
		if (is_array($dados)){
			foreach ($dados as $variavel=>$valor){
				$this->_arquivo = str_replace("[".$variavel."]",utf8_decode($valor),$this->_arquivo);
			}
		}
	}

	private function _abreArquivo($nomeArquivo){
		$arquivo = file(dirname(__FILE__)."/tplEmails/".$nomeArquivo);
		$this->_arquivo = implode("\n",$arquivo);
	}

	public function novoContato($dados, $envio) {
		$this->_abreArquivo(self::EMAIL_NOVO_CONTATO);
		$this->varredura($dados);
		$this->enviar($envio);
	}

	protected function enviar($dados){
		// Enviar o link para o e-mail do usuário
		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->SMTPAuth		= self::PHPMAILER_SMTPAUTH;
		$mail->SMTPSecure	= self::PHPMAILER_SMTPSECURE;
		$mail->Host			= self::PHPMAILER_HOST;
		$mail->Username		= self::PHPMAILER_USERNAME;
		$mail->Password		= self::PHPMAILER_PASSWORD;
		$mail->Port			= self::PHPMAILER_PORT;

		$mail->setFrom($dados['from'], utf8_decode($dados['from_name']));
		if (is_array($dados['to'])) {
			foreach ($dados['to'] as $receiver){
				$mail->addAddress($receiver, $dados['to_name']);
			}
		} else {
			$mail->addAddress($dados["to"], $dados['to_name']);
		}
		if (is_array($dados['cc'])) {
			foreach ($dados['cc'] as $receiver){
				$mail->addCC($receiver);
			}
		} else {
			$mail->addCC($dados["cc"]);
		}
		if (is_array($dados['bcc'])) {
			foreach ($dados['bcc'] as $receiver){
				$mail->addBCC($receiver);
			}
		} else {
			$mail->addBCC($dados["bcc"]);
		}

		$mail->isHTML(true);
		$mail->Subject = utf8_decode($dados['subject']);
		$mail->Body = $this->_arquivo;

		if(!$mail->send()) {
			$mail->Host			= self::PHPMAILER_HOST2;
			$mail->Username		= self::PHPMAILER_USERNAME2;
			$mail->Password		= self::PHPMAILER_PASSWORD2;
			$mail->Port			= self::PHPMAILER_PORT2;
			if(!$mail->send()) {
				echo "Erro no envio de email: " . $mail->ErrorInfo;
			}
		}
	}

}