<?PHP
/* pegar os parametros se mandou por POST ou GET */
$_INPUT = file_get_contents("php://input");
if (empty($_INPUT))
  $_INPUT=array();
/* pegar os parametros por URL */
parse_str($_SERVER['QUERY_STRING'], $url_params);
$_INPUT = array_merge($_INPUT, $url_params);

if($_INPUT['type']=="json"){
    $typeRequest = "json";
    header('Content-type: application/json');
} else {
    $typeRequest = "js";
    header('Content-type: application/javascript');
}
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0, false');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Pragma: no-cache');

/*
    The Example read files of a directory and outputs
    a javascript array. Output is:

    var InternPagesSelectBox = new Array(
        new Array( empty, empty ),
        new Array( name, link ),
        new Array( name, link )...
    );

    InternPagesSelectBox will loaded as select options
    to internpage plugin.
*/

$directory = "../../../../../site/html/paginas";
$handle = opendir ($directory);

if($typeRequest == "json"){
    echo '[{"label":"-- Selecione uma Página --","url":""}';
    while (false !== ($file = readdir ($handle))) {
        if ( $file != "." && $file != ".." ){
            $page_url = realpath($directory)."/".$file;
            $content = file_get_contents($page_url);
            preg_match_all('#<div class="composs-panel-title"><strong>(.*?)</strong></div>#sim', $content, $div_array);
            $newTitle = explode(".",$file);
            echo ',{"label":"'.(trim(isset($div_array[1][0]))?trim($div_array[1][0]):$file).'","url":"/pagina.php?c='.$newTitle[0].'"}';
        }
    }
    echo "]";
} elseif($typeRequest == "js"){
    echo "var InternPagesSelectBox = new Array( new Array( '', '' )";
    while (false !== ($file = readdir ($handle))) {
        if ( $file != "." && $file != ".." ){
            $page_url = realpath($directory)."/".$file;
            $content = file_get_contents($page_url);
            preg_match_all('#<div class="composs-panel-title"><strong>(.*?)</strong></div>#sim', $content, $div_array);
            $newTitle = explode(".",$file);
            echo ", new Array( '".(trim(isset($div_array[1][0]))?trim($div_array[1][0]):$file)."', '/pagina.php?c=".$newTitle[0]."' )";
        }
    }
    echo " );\n";
}

closedir($handle);

?>
