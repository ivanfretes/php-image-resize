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
		private static $filePath;
		private $porcentaje;
		private static $imgWidthOrigin;
		private static $imgHeightOrigin;
		private static $imgWidthDefault;
		private static $imgHeightDefault;
		private static $mimeType;
		private $imgsetName;
		private $newPath;



		public function assignName($name){
			$name = str_replace(' ', '_', $name);
			$this->imgsetName = $name;
		}


		public function __construct($filePath, $dimensiones = NULL){
			// Ruta del archivo
			self::$filePath = $filePath;

			// Obtenemos las dimensiones originales del archivo
			$imgInfo = getimagesize(self::$filePath);

			self::$imgWidthOrigin = $imgInfo[0];
			self::$imgHeightOrigin = $imgInfo[1];

			// Tipo mime del archivo
			$this->mimeType = $imgInfo["mime"]; 

			// Cargamos los datos por defecto
			
			if (gettype($dimensiones) == "array")
				$this->resizeImgByPixeles($dimensiones);
			else 
				$this->resizeImgByPorcentaje($dimensiones);
			
			// Definimos el nombre por defecto
			$this->dataDefault();
		}

		public function getmimeType(){
			// Test Visual Studio Git Tools
			return $this->mimeType;
		}


		// Re define the new size for image 
		public function resizeImg($dimensiones = NULL){
			if ($dimensiones !== NULL){
				$canvasSize = imagecreatetruecolor(	$dimensiones[0],
													$dimensiones[1]);
			}
			else {
				$canvasSize = imagecreatetruecolor(	self::$imgWidthDefault,
													self::$imgHeightDefault);
			}

			$this->imgCreateByFormat($canvasSize);

		}


		/*
			This static function simplify the process of call various method. That depends of the programmer
		*/
		public static function _resizeImg(	$path,$imgsetName, 
											$dimensiones, $folder){

		} 




		// Set a default values of img name and new path/directory name
		protected function dataDefault(){
			if (!isset($this->imgsetName)){
				$this->imgsetName = basename(self::$filePath)."_thumb_";
				$this->imgsetName .= self::$imgWidthDefault."x";
				$this->imgsetName .= self::$imgHeightDefault."_";
				$this->imgsetName .= sha1(date("Y-m-d H:i:s"));
			}
			if (!isset($this->newPath))
				$this->newPath = "img/upload";				
		}


		public function setPathImg($path){
			//$path = str_replace(' ', '', $path);
			$this->newPath = $path;
		}


		// Puede acontecer una excepcion
		public function getPathImg(){
			return $this->newPath;	
		}

		// View Permit of path
		protected function viewPathPermit(){
			if (!file_exists($this->newPath)){
				mkdir($this->newPath);
			}

			$permitInOctal = sprintf('%o', fileperms($this->newPath));
 			//echo $permitInOctal;
		} 


		// Making a MIME type image
		protected function imgCreateByFormat($canvas){
			//header("Content-type:".$this->mimeType);
			$imgFileName = $this->newPath."/".$this->imgsetName;

			$this->viewPathPermit();
			switch ($this->mimeType) {
				case 'image/jpeg':
					$img = imagecreatefromjpeg(self::$filePath);
					imagecopyresampled($canvas, $img, 0, 0, 0, 0, 
										self::$imgWidthDefault, 
										self::$imgHeightDefault,
										self::$imgWidthOrigin,
										self::$imgHeightOrigin);
					
					imagejpeg($canvas,$imgFileName.".jpg");
					break;

				case 'image/png':
					// Set transparency of a png image
					
					imagesavealpha($canvas, true);
					$color = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
					imagefill($canvas, 0, 0, $color);
					

					$img = imagecreatefrompng(self::$filePath);
					imagecopyresampled($canvas, $img, 0, 0, 0, 0, 
										self::$imgWidthDefault, 
										self::$imgHeightDefault,
										self::$imgWidthOrigin,
										self::$imgHeightOrigin);
					
					imagepng($canvas,$imgFileName.".png");
					break;

				case 'image/gif':
					$img = imagecreatefromgif(self::$filePath);
					imagecopyresampled($canvas, $img, 0, 0, 0, 0, 
										self::$imgWidthDefault, 
										self::$imgHeightDefault,
										self::$imgWidthOrigin,
										self::$imgHeightOrigin);
					imagegif($canvas,$imgFileName.".gif");
					break;

				default:
					break;
			}

			imagedestroy($img);
		}

		// New dimensions by width and height pixels
		public function resizeImgByPixeles($dimensiones){

			list( self::$imgWidthDefault, 
				  self::$imgHeightDefault) = $dimensiones;
		}

		
		// New dimensions by percentage
		public function resizeImgByPorcentaje($porcentaje){

			self::$imgWidthDefault = self::$imgWidthOrigin * $porcentaje;
			self::$imgHeightDefault = self::$imgHeightOrigin * $porcentaje;

		}
	}

?>