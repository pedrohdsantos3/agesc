<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
include("../configs/header.class.php");
$redir = new Redirect();

include("classes/controlauser.class.php");

include("classes/t_header.class.php");
include("classes/t_menuleft.class.php");
include("classes/t_content.class.php");
include("classes/t_menuright.class.php");
include("classes/t_footer.class.php");

$header = new Header("html/header.html");
$menul = new Menuleft("html/menuleft.html");
$menur = new Menuright("html/menuright.html");
$footer = new Footer("html/footer.html");

include("classes/niveis.class.php");
include("classes/dateformat.class.php");
$datas = new Data();
?>
