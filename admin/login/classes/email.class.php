<?php
	class Email{
		
		public function enviaEmail($id, $email, $nome, $msg){
			
		$headers = "MIME-Version: 1.0\n";  
		
		$headers.= "From: Novo Pedido <contato@.com.br>\r\n";
		
		$boundary = "XYZ-" . date("dmYis") . "-ZYX";
		
		$headers.= "Content-type: multipart/mixed; boundary=\"$boundary\"\r\n";  
		$headers.= "$boundary\n"; 
		
		
		
		$conteudo = $msg;
		
		$corpo_mensagem = "<html>
		<head>
		   <title>Licença de Software</title>
		</head>
		<body'>
		".$conteudo.
		"</font>
		</body>
		</html>";
		
		
		$mensagem = "--$boundary\n"; 
		$mensagem.= "Content-Transfer-Encoding: 8bits\n"; 
		$mensagem.= "Content-Type: text/html; charset=\"ISO-8859-1\"\n\n";
		$mensagem.= "$corpo_mensagem\n"; 
		$mensagem.= "--$boundary\n"; 
		$mensagem.= "Content-Type: \n";  
		$mensagem.= "Content-Disposition: attachment; filename=\"\"\n";  
		$mensagem.= "Content-Transfer-Encoding: base64\n\n";  
		$mensagem.= "$anexo\n";  
		$mensagem.= "--$boundary--\r\n"; 
		
		
				
			$destinatario = $email;
			
			$assunto = "Teste";
			
			
			mail($destinatario, $assunto, $mensagem, $headers);  
			
			
			return true;
		
		  
		
		
		}
}
?>