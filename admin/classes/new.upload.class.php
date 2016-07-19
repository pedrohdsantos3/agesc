<?php
class Av5_Upload {

	protected $_destino;
	protected $_nomeInput;
	protected $_arquivo;
	protected $_prefixo;

	function __construct($destino, $nomeInput, $prefixo="imagem_"){
		$this->_destino = $destino;
		$this->_nomeInput = $nomeInput;
		$this->_prefixo = $prefixo;
		$this->executa();
	}

	function executa(){
		$adapter = new Zend_File_Transfer_Adapter_Http();
		$adapter->setDestination($this->_destino);
		$arquivo = $adapter->getFileInfo($this->_nomeInput);
		$extensao = substr($arquivo[$this->_nomeInput]["name"], strrpos($arquivo[$this->_nomeInput]["name"], '.') + 1);
		//$nomeArquivo = $this->_prefixo . date('dmYhis').'.'.$extensao;
		$nomeArquivo = $arquivo[$this->_nomeInput]["name"];
		if (file_exists($this->_destino . $nomeArquivo)) {
			$nomeArquivo = date('YmdHi') . "-" . $nomeArquivo;
		}
		$adapter->addFilter('Rename',array('target'=>$this->_destino . $nomeArquivo,'overwrite'=>false));
		$adapter->receive();
		$this->_arquivo = $nomeArquivo;
		$this->trataImagem();
	}

	public function getFileName(){
		return $this->_arquivo;
	}

	private function trataImagem(){
		$configs = Zend_Registry::get('config');

		# Medidas da imagem original
		$oW = $this->getWidth($this->_destino . $this->_arquivo);
		$oH = $this->getHeight($this->_destino . $this->_arquivo);

		/** Imagens padrão **/
		$this->criaImagem($configs->imagens->thumb,$oW,$oH,'thumb');
		$this->criaImagem($configs->imagens->mid,$oW,$oH,'mid');
		$this->criaImagem($configs->imagens->big,$oW,$oH,'big');

		/** Banners **/
		$this->criaImagem($configs->banners->principal,$oW,$oH,'pri');
		$this->criaImagem($configs->banners->horizontal,$oW,$oH,'hor');
		$this->criaImagem($configs->banners->lateral,$oW,$oH,'lat');
	}

	private function criaImagem($cfg, $width, $height, $prefix){
		# Só deve redimensionar se ambas medidas forem maiores que os padrões
		if ( ($width >= $cfg->width) || ($height >= $cfg->height) ){
			# Cálcula a escala de redimensionamento da imagem
			if($width == $cfg->width) {
				$scale = 1;
			} else {
				$scale = $cfg->width / $width;
			}

			$nome = $this->_destino . $prefix . "-" . $this->_arquivo;
			$nova = imagecreatetruecolor($width,$height);
			$original = imagecreatefromstring(file_get_contents($this->_destino . $this->_arquivo));
			imagecopyresampled($nova, $original, 0, 0, 0, 0, $width, $height, $width, $height);
			imagejpeg($nova, $nome, 100);

			if ($cfg->resize == 1) {
				$redimensionado = $this->resizeImage($nome,$width,$height,$scale);
			} else {
				$midW = ceil( ($width - $cfg->width) / 2 );
				if ($midW < 0) $midW = $midW * (-1);
				$midH = ceil( ($height - $cfg->height) / 2 );
				if ($midH < 0) $midH = $midH * (-1);
				$crop = $this->resizeThumbnailImage($nome,$this->_destino.$this->_arquivo,$cfg->width,$cfg->height,$midW,$midH,1);
			}
		}
	}

	function resizeImage($image,$width,$height,$scale) {
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$imageType = image_type_to_mime_type($imageType);
		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		switch($imageType) {
			case "image/gif":
				$source=imagecreatefromgif($image);
				break;
		    case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image);
				break;
		    case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image);
				break;
	  	}
		imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);

		switch($imageType) {
			case "image/gif":
		  		imagegif($newImage,$image);
				break;
	      	case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
		  		imagejpeg($newImage,$image,90);
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$image);
				break;
	    }

		chmod($image, 0777);
		return $newImage;
	}

	function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
		list($imagewidth, $imageheight, $imageType) = getimagesize($image);
		$imageType = image_type_to_mime_type($imageType);

		$newImageWidth = ceil($width * $scale);
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		switch($imageType) {
			case "image/gif":
				$source=imagecreatefromgif($image);
				break;
		    case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
				$source=imagecreatefromjpeg($image);
				break;
		    case "image/png":
			case "image/x-png":
				$source=imagecreatefrompng($image);
				break;
	  	}
		imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
		switch($imageType) {
			case "image/gif":
		  		imagegif($newImage,$thumb_image_name);
				break;
	      	case "image/pjpeg":
			case "image/jpeg":
			case "image/jpg":
		  		imagejpeg($newImage,$thumb_image_name,90);
				break;
			case "image/png":
			case "image/x-png":
				imagepng($newImage,$thumb_image_name);
				break;
	    }
		chmod($thumb_image_name, 0777);
		return $thumb_image_name;
	}

	function getHeight($image) {
		$size = getimagesize($image);
		$height = $size[1];
		return $height;
	}

	function getWidth($image) {
		$size = getimagesize($image);
		$width = $size[0];
		return $width;
	}
}

?>