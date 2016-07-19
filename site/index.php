<?php
function mr_slugify($string) {
    $string = transliterator_transliterate("Any-Latin; NFD; [:Nonspacing Mark:] Remove; NFC; [:Punctuation:] Remove; Lower();", $string);
    $string = preg_replace('/[-\s]+/', '-', $string);
    return trim($string, '-');
}

function mr_getUrlFromId($bloco)
{
	include "../configs/conexao.class.php";

	$url=trim($bloco['post_url']);
    if ($url=='') {

    	$url=$bloco['post_titulo'];
    	$url=iconv("ISO-8859-1", "UTF-8", $url);
    	$url=mr_slugify($url);

    	while (strpos("*$url","  ")>0)
    	  $url=str_replace("  ", " ", $url);
    	$url=str_replace(" ", "-", $url);
    	$url="posts/".$url;

    	$bloco['post_url']=$url;

    	$id=$bloco['post_id'];
    	$ex=$pdo->prepare("update post set post_url='$url' where post_id='$id'");
    	$ex->execute();


    }
    return $url;
}

include("controletemp/includes.php");

	$header->TITLE_PAGE = "Home";
	$cont = new Content("html/tpl-index.html");

	$blocolarge = $site->Ret_noticia_Bgrande();
	foreach($blocolarge as $bloco =>$bl){

		//$cont->POST_IDBL		= $bl["post_id"];
		$cont->POST_URLBL         = mr_getUrlFromId($bl);
		$cont->TITLE_POSTBL		= utf8_encode($bl["post_titulo"]);
		$cont->RESUMO_POSTBL	= utf8_encode($bl["post_subtitulo"]);
		$cont->DATE_POSTBL		= $datas->DataBr($bl["post_data"]);
		$cont->IMGBL			= @getimagesize($bl["imagem_link"])?$bl["imagem_link"]:$baseUrl."images/404-image.png";
		$cont->block("BLOCK_ITEMLARGE");
	}







	$destaques = $site->Ret_destaques();
	foreach($destaques as $destaque =>$dstq){ // 4 por slide

		$mainslide->TITLE_POST	= utf8_encode($dstq["post_titulo"]);
    $mainslide->POST_URLBD         = mr_getUrlFromId($dstq);
	//	$mainslide->POST_ID		= $dstq["post_id"];
		$mainslide->DATE_POST	= $datas->DataBr($dstq["post_data"]);
		$mainslide->IMG_MAIN	= @getimagesize($dstq["imagem_link"])?$dstq["imagem_link"]:$baseUrl."images/404-image.png";
		$mainslide->block("BLOCK_ITEMMAINSLIDE");
	}
	$footer->block("BLOCK_JSMAINSLIDER");
	$mainslide->block("BLOCK_MAINSLIDE");


include("controletemp/views.php");
?>
