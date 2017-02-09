<?
/*
Copyright <2017> <Ivan Fretes>

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in 
the Software without restriction, including without limitation the rights to 
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of 
the Software, and to permit persons to whom the Software is furnished to do so, 
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all 
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS 
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR 
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER 
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN 
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/

namespace PHPResizeImg;

	class ResizeImg {
		private $filePath;
		private $porcentaje;
		private static $imgWidthOrigin;
		private static $imgHeightOrigin;
		private static $imgWidthDefault;
		private static $imgHeightDefault;
		private static $mimeType;
		private $imgsetName;
		private $newPath;


		public function assignName($name){
			$this->imgsetName = $name;
		}

		public function __construct($filePath, $dimensiones = NULL){
			// Ruta del archivo
			$this->filePath = $filePath;

			// Obtenemos las dimensiones originales del archivo
			$imgInfo = getimagesize($this->filePath);
			self::$imgWidthOrigin = $imgInfo[0];
			self::$imgHeightOrigin = $imgInfo[1];

			// Tipo mime del archivo
			$this->mimeType = $imgInfo["mime"]; 

			// Cargamos los datos por defecto
			$this->dataDefault();


			if (gettype($dimensiones) == "array")
				$this->resizeImgByPixeles($dimensiones);
			else 
				$this->resizeImgByPorcentaje($dimensiones);
			
		}

		public function getmimeType(){
			return $this->mimeType;
		}

		public function resizeImg($dimensiones = NULL){
			if ($dimensiones !== NULL){
				$canvasSize = imagecreatetruecolor(	$dimensiones[0],
													$dimensiones[1]);
			}
			else {
				$canvasSize = imagecreatetruecolor(	self::$imgWidthDefault,
													self::$imgHeightDefault);
			}

			//header("Content-type:".$this->mimeType);
			$this->imgCreateByFormat($canvasSize);

		}

		protected function dataDefault(){
			if (!isset($this->imgsetName))
				$this->imgsetName = "defaultImg".sha1(date("Y-m-d H:i:s"));


			if (!isset($this->newPath))
				$this->newPath = "img/upload";				
		}

		public function setPathImg($path){
			$this->newPath = $path;
		}

		// Verifica permisos 
		protected function viewPathPermit(){
			if (!file_exists($this->newPath)){
				mkdir($this->newPath);
			}

			$permitInOctal = sprintf('%o', fileperms($this->newPath));
 			//echo $permitInOctal;
		} 


		// Crea la imagen segun el tipo mime
		private function imgCreateByFormat($canvas){
			$imgPathName = $this->newPath."/".$this->imgsetName;

			$this->viewPathPermit();
			switch ($this->mimeType) {
				case 'image/jpeg':
					$origen = imagecreatefromjpeg($this->filePath);
					imagecopyresampled($canvas, $origen, 0, 0, 0, 0, 
										self::$imgWidthDefault, 
										self::$imgHeightDefault,
										self::$imgWidthOrigin,
										self::$imgHeightOrigin);
					
					$pathName = $imgPathName.".jpg";
					imagejpeg($canvas,$pathName);
					
					break;

				case 'image/png':
					$origen = imagecreatefrompng($this->filePath);
					imagecopyresampled($canvas, $origen, 0, 0, 0, 0, 
										self::$imgWidthDefault, 
										self::$imgHeightDefault,
										self::$imgWidthOrigin,
										self::$imgHeightOrigin);
					imagepng($canvas,$imgPathName.".png");
					break;

				case 'image/gif':
					$origen = imagecreatefromgif($this->filePath);
					imagecopyresampled($canvas, $origen, 0, 0, 0, 0, 
										self::$imgWidthDefault, 
										self::$imgHeightDefault,
										self::$imgWidthOrigin,
										self::$imgHeightOrigin);
					imagegif($canvas,$imgPathName.".gif");
					break;

				default:
					break;
			}
			
		}

		// Contiene las nuevas dimensiones, de la imagen 
		public function resizeImgByPixeles($dimensiones){

			list(self::$imgWidthDefault, 
				 self::$imgHeightDefault) = $dimensiones;
		}

		

		public function resizeImgByPorcentaje($porcentaje){

			self::$imgWidthDefault = self::$imgWidthOrigin * $porcentaje;
			self::$imgHeightDefault = self::$imgHeightOrigin * $porcentaje;

		}
	}

?>