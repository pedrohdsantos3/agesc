<?php
include("classes/conexao.class.php");
$directory = "html/paginas";
$handle = opendir ($directory);

while (false !== ($file = readdir ($handle))) {
    if ( $file != "." && $file != ".." ){
        $page_url = realpath($directory)."/".$file;
        $content = file_get_contents($page_url);
        preg_match_all('#<div class="composs-panel-title"><strong>(.*?)</strong></div>#sim', $content, $div_array);
        $newTitle = $div_array[1][0];

        echo $newTitle."</br>";
      }
    }


?>
