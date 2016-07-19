<?php
 class Imagem
 {
  public $miniatura;
  public $img;
  private $img_origem;
  private $img_final;
   function __construct($img,$pasta,$largura,$altura)
	{
	   $this->img = $pasta.'/'.$img['name'];
	   move_uploaded_file($img['tmp_name'], $this->img);
	   $miniatura = explode('.', $this->img);
	   $this->miniatura = $miniatura[0].'_mini.jpg';
	   $this->img_origem = ImageCreateFromJPEG($this->img);
	   $x = ImagesX($this->img_origem);
	   $y = ImagesY($this->img_origem);
	   $this->img_final = ImageCreateTrueColor($largura,$altura);
	   ImageCopyResampled($this->img_final, $this->img_origem, 0, 0, 0, 0, $largura+1, $altura+1, $x , $y);
	   ImageJPEG($this->img_final, $this->miniatura);
	 }
	function __destruct()
	 {
	  ImageDestroy($this->img_origem);
	  ImageDestroy($this->img_final);
	 }
 }
?>
