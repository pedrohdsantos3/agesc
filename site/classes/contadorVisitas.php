<?php

 //  Configurações do Script
 // ==============================
 $_CV['registraAuto'] = true;       // Registra as visitas automaticamente?
 $_CV['conectaMySQL'] = true;       // Abre uma conexão com o servidor MySQL?
 $_CV['iniciaSessao'] = true;       // Inicia a sessão com um session_start()?
 $_CV['servidor'] = 'localhost';    // Servidor MySQL
 $_CV['usuario'] = 'sindasp_sitebd';          // Usuário MySQL
 $_CV['senha'] = 'sindasp12345';                // Senha MySQL
 $_CV['banco'] = 'sindasp_site';            // Banco de dados MySQL
 $_CV['tabela'] = 'visitas';        // Nome da tabela onde os dados são salvos
 // ==============================
 // ======================================
 //   ~ Não edite a partir deste ponto ~
 // ======================================
 // Verifica se precisa fazer a conexão com o MySQL
 if ($_CV['conectaMySQL'] == true) {
    $_CV['link'] = mysql_connect($_CV['servidor'], $_CV['usuario'], $_CV['senha']) or die("MySQL: Não foi possível conectar-se ao servidor [".$_CV['servidor']."].");
    mysql_select_db($_CV['banco'], $_CV['link']) or die("MySQL: Não foi possível conectar-se ao banco de dados [".$_CV['banco']."].");
 }
 // Verifica se precisa iniciar a sessão
 if ($_CV['iniciaSessao'] == true) {
    session_start();
 }
/**
 * Registra uma visita e/ou pageview para o visitante
 */
 function getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

 function registraVisita() {
    global $_CV;
    $ip = getUserIP();
    $table=$_CV['tabela'];
    /* caso queira marcar por hora
    $cdate=date("Y-m-d H");
    */
  //  $c=isset($_GET['c'])?$_GET['c']:'';
    if(isset($_GET['c'])){
      $c=$_GET['c'];
    }elseif(isset($_GET['id'])){
      $c = $_GET['id'];
    }else{
      $c = '';
    }
    $cdate=date("Y-m-d");
    $wclause="data='$cdate' and ip='$ip' and c='$c'";
    $sql = "SELECT COUNT(*) FROM `$table` WHERE $wclause";
    $query = mysql_query($sql);
    $resultado = mysql_fetch_row($query);

    // Verifica se é uma visita (do visitante)
    $nova = (!isset($_SESSION['ContadorVisitas'])) ? true : false;
    // Verifica se já existe registro para o dia
    if ($resultado[0] == 0) {
        $sql = "INSERT INTO `$table` (ip, data, uniques, pageviews, c) VALUES ('$ip', '$cdate', 1, 1, '$c')";
      //  print_r($sql);
      //  exit;
    } else {
        if ($nova == true) {
            $sql = "UPDATE `$table` SET `uniques` = (`uniques` + 1), `pageviews` = (`pageviews` + 1) WHERE $wclause";
        } else {
            $sql = "UPDATE `$table` SET `pageviews` = (`pageviews` + 1) WHERE $wclause";
        }
    }
    // Registra a visita
    mysql_query($sql);
    // Cria uma variavel na sessão
    $_SESSION['ContadorVisitas'] = md5(time());
 }
/**
 * Função que retorna o total de visitas
 *
 * @param string $tipo - O tipo de visitas a se pegar: (uniques|pageviews)
 * @param string $periodo - O período das visitas: (hoje|mes|ano)
 *
 * @return int - Total de visitas do tipo no período
 */
 function pegaVisitas($tipo = 'uniques', $periodo = 'hoje') {
    global $_CV;
    switch($tipo) {
        default:
        case 'uniques':
            $campo = 'uniques';
            break;
        case 'pageviews':
            $campo = 'pageviews';
            break;
    }
    switch($periodo) {
        default:
        case 'hoje':
            $busca = "`data` = CURDATE()";
            break;
        case 'mes':
            $busca = "`data` BETWEEN DATE_FORMAT(CURDATE(), '%Y-%m-01') AND LAST_DAY(CURDATE())";
            break;
        case 'ano':
            $busca = "`data` BETWEEN DATE_FORMAT(CURDATE(), '%Y-01-01') AND DATE_FORMAT(CURDATE(), '%Y-12-31')";
            break;
    }
    // Faz a consulta no MySQL em função dos argumentos
    $sql = "SELECT SUM(`".$campo."`) FROM `".$_CV['tabela']."` WHERE ".$busca;
    $query = mysql_query($sql);
    $resultado = mysql_fetch_row($query);
    // Retorna o valor encontrado ou zero
    return (!empty($resultado)) ? (int)$resultado[0] : 0;
 }
 if ($_CV['registraAuto'] == true) { registraVisita(); }
