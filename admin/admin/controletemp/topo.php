<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include("../configs/header.class.php");
$redir = new Redirect();

include("classes/controlauser.class.php");

require_once("Template/template/view/Template.php");     
use template\view\Template;

$cont = new Template("html/template.html");
$cont->addFile("HEADER", "html/header.html");
$cont->addFile("MENULEFT", "html/menuleft.html");
$cont->addFile("FOOTER", "html/footer.html");

/*$header = new Header("html/header.html");
$menul = new Menuleft("html/menuleft.html");
// $menur = new Menuright("html/menuright.html");
$footer = new Footer("html/footer.html");*/

include("../configs/controlamenu.php");


//include("classes/niveis.class.php");
//include("classes/dateformat.class.php");
//$datas = new Data();
?>
