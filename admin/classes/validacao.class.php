<?php



/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */



/**

 * Description of validacao

 *

 * @author CaffeinePgr

 */

class Validacao {

    //put your code here

   public function validarCPF( $cpf ) {



    	$cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);

    	// Verifica se nenhuma das sequ�ncias abaixo foi digitada, caso seja, retorna falso

    	if ( strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {

    		return FALSE;

    	} else { // Calcula os n�meros para verificar se o CPF � verdadeiro

    		for ($t = 9; $t < 11; $t++) {

    			for ($d = 0, $c = 0; $c < $t; $c++) {

    				$d += $cpf{$c} * (($t + 1) - $c);

    			}

    			$d = ((10 * $d) % 11) % 10;

    			if ($cpf{$c} != $d) {

    				return FALSE;

    			}else{
            return true;
          }

    		}


    	}

    }

      public function validaRG($rg){


	   $rg = str_pad(preg_replace('/[^0-9]/', '', $rg), 9, '0', STR_PAD_LEFT);

            if ( strlen($rg) != 9 || $rg == '000000000' || $rg == '111111111' || $rg == '222222222' || $rg == '333333333' || $rg == '444444444' || $rg == '555555555' || $rg == '666666666' || $rg == '777777777' || $rg == '888888888' || $rg == '999999999') {

		      return FALSE;

	       }else
              return TRUE;

      }





function valida_cnpj ( $cnpj ) {

    $cnpj = preg_replace( '/[^0-9]/', '', $cnpj );

    $cnpj = (string)$cnpj;

    $cnpj_original = $cnpj;

    $primeiros_numeros_cnpj = substr( $cnpj, 0, 12 );

    if ( ! function_exists('multiplica_cnpj') ) {
        function multiplica_cnpj( $cnpj, $posicao = 5 ) {

            $calculo = 0;

            for ( $i = 0; $i < strlen( $cnpj ); $i++ ) {

                $calculo = $calculo + ( $cnpj[$i] * $posicao );
                $posicao--;

                if ( $posicao < 2 ) {
                    $posicao = 9;
                }
            }
            return $calculo;
        }
    }

    $primeiro_calculo = multiplica_cnpj( $primeiros_numeros_cnpj );


    $primeiro_digito = ( $primeiro_calculo % 11 ) < 2 ? 0 :  11 - ( $primeiro_calculo % 11 );


    $primeiros_numeros_cnpj .= $primeiro_digito;


    $segundo_calculo = multiplica_cnpj( $primeiros_numeros_cnpj, 6 );
    $segundo_digito = ( $segundo_calculo % 11 ) < 2 ? 0 :  11 - ( $segundo_calculo % 11 );


    $cnpj = $primeiros_numeros_cnpj . $segundo_digito;


    if ( $cnpj === $cnpj_original ) {
        return true;
    }else{
        return false;
    }
}




    public function validaEmail($mail){

      	if(preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(.[[:lower:]]{2,3})(.[[:lower:]]{2})?$/", $mail)) {

      		return true;

      	}else{

      		return false;

      	}

    }





    public function validaCEP($cep){

            $pattern = "/^[0-9]{5}-[0-9]{3}$/";



            if (preg_match($pattern, $cep)) {

              return true;

            } else {

              return false;

            }

    }



    public function validaNOME($nome){

        if(strlen($nome) < 3){

            return false;

        }else{

            return true;

        }

    }



    public function validaUSER($usuario){

        if(strlen($usuario) < 6){

            return false;

        }else{

            return true;

        }

    }

        public function validaDatanasc($dtnasc){

        if(strlen($dtnasc) != 10){

            return false;

        }else{

            return true;

        }

    }



    public function validaSENHA($senha){

        if(strlen($senha) < 6){

            return false;

        }else{

            return true;

        }

    }



    public function verificaTERMOS($termos){

        if($termos > 0){

            return true;

        }elseif($termos == 0){

            return false;

        }

    }



    public function confirmaSENHA($senha, $confirma){

        if($senha == $confirma){

            return true;

        }else{

            return false;

        }

    }



    public function validaTEL($telefone){

        if(strlen($telefone) != 14 ){

            return false;

        }else{

            return true;

        }

    }

     public function validaCEL($celular){

        if(strlen($celular) != 15 ){

            return false;

        }else{

            return true;

        }

    }

    public function confirmaESTADO($estado){

        if(strlen($estado) != 2){

            return false;

        }else{

            return true;

        }

    }



    public function validaNUM($numero){

        if(is_numeric($numero) && strlen($numero) > 0){

            return true;

        }else{

            return false;

        }

    }



    public function verificaEND($endereco){
        if(strlen($endereco) >2){

            return true;

        }else{

            return false;

        }

    }



    public function existeCNPJ($cnpj){

      include("../configs/conexao.class.php");



        $ver = $pdo->prepare("SELECT * FROM clientes WHERE cli_cnpj = '$cnpj'");

        $ver->execute();

        $count = $ver ->rowCount();

        if($count > 0){

            return true;

        }else{

            return false;

        }

    }



 /*   public function existeCPF($cpf){

        include("classes/conexao.class.php");



        $ver = $pdo->prepare("SELECT * FROM usuarios WHERE usu_cpf = '$cpf'");

        $ver->execute();

        $count = $ver ->rowCount();

        if($count > 0){

            return true;

        }else{

            return false;

        }

    }*/



    public function existeEMAIL($email){

      include("../configs/conexao.class.php");





        $ver = $pdo->prepare("SELECT * FROM clientes WHERE cli_email = '$email'");

            $ver->execute();

            $count = $ver ->rowCount();

            if($count > 0){

                return true;

            }else{

                return false;

            }

    }





    public function existeEMAILuser($email){

      include("../configs/conexao.class.php");





        $ver = $pdo->prepare("SELECT * FROM usuarios WHERE usu_email = '$email'");

            $ver->execute();

            $count = $ver ->rowCount();

            if($count > 0){

                return true;

            }else{

                return false;

            }

    }





    public function existeUSER($usuario){

      include("../configs/conexao.class.php");



        $ver = $pdo->prepare("SELECT * FROM cli_user WHERE usuario_cli = '$usuario'");

        $ver->execute();

        $count = $ver->rowCount();

        if($count >0){

            return true;



        }else{

            return false;

        }

    }

    public function existeCPF($cpf){

      include("../configs/conexao.class.php");



        $ver = $pdo->prepare("SELECT * FROM usuarios WHERE usu_cpf = '$cpf'");

        $ver->execute();

        $count = $ver->rowCount();


        if($count >0){

            return true;



        }else{

            return false;

        }

    }





    public function pegaID($cnpj){



      include("../configs/conexao.class.php");

        $ver = $pdo->prepare("SELECT id FROM clientes WHERE cli_cnpj = '$cnpj'");

        $ver->execute();



        foreach($ver as $ve =>$v){



            return  $v["id"];

        }





    }



    public function pegaIDuser($cpf){



      include("../configs/conexao.class.php");

        $ver = $pdo->prepare("SELECT usu_id FROM usuarios WHERE usu_cpf = '$cpf'");

        $ver->execute();



        foreach($ver as $ve =>$v){



            return  $v["usu_id"];

        }





    }



}



?>
