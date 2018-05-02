<?

$PERCENT = 100;

class ImageResize {

	/**
	 * @var {mixed} ref: data of image origin
	 */
	protected $filePath;
	protected $mimeType;
	protected $heightOrigin;
	protected $widthOrigin;
	protected $nameOrigin;
	protected $sizeOrigin;


	/**
	 * @var {mixed} ref: a new image generated 
	 */
	protected $format;
	protected $newName;
	protected $newPath;
	protected $newWidth;
	protected $newHeight;


	/**
	 * Data assigned by default
	 * 
	 * @var {string} $porcents [0...1]  
	 * @var {mixed} $mimeTypeSupport Mime Type Supported
	 * @var {boolean} $resizeByPorcent if the resizing by $porcents
	 */
	protected $percent = 1;
	protected $resizeByPorcent = FALSE;
	protected $mimeTypeSupport = array(
		'image/jpeg' =>  'resizeJPEG',
		'image/gif' =>  'resizeGIF', 
		'image/png' =>  'resizePNG'
	);
	protected $canvas;


	/**
	 * Setting the new sizes by width
	 * @param {number} $newWidth
	 */
	public function setWithWidth($newWidth){
		$newHeight = ( $this->heightOrigin * $newWidth / 
					   $this->widthOrigin );
		$this->setDimensions($newWidth, $newHeight);
	}


	/**
	 * Setting the new sizes with dimensions
	 * @param {number} $newHeight
	 */
	public function setWithHeight($newHeight){
		$newWidth = ( $this->widthOrigin * $newHeight / 
					  $this->heightOrigin );
		$this->setDimensions($newWidth, $newHeight);
	}


	public function resize(){
		$resize = $this->mimeTypeSupport[$this->mimeType];

		header("Content-type:".$this->mimeType);
		$this->canvas = imagecreatetruecolor($this->newWidth, $this->Height);
		$this->$resize();
	}


	/**
	 * Updated the name of the image. 
	 * (*) Default replacement dash instead white space key
	 * 
	 * @param {string} 
	 */
	/*public function removeWhiteSpace($name, $newChar = '-'){
		$this->newName = str_replace(
			' ', $newCharacter, $this->newNameImage
		);
	}*/


	/**
	 * Verify that the file exists
	 * @param {string} $filePath
	 */
	protected function verifyPath($filePath){
		try {
			if (!is_file($filePath)) {
				throw new Exception("Verify that the file exists");
			}
			$this->filePath = $filePath;

		} catch (Exception $e) {
			echo $e->getMessage();
			exit;
		}
	}


	/**
	 * @param {string} $filePath route of the files
	 * @param {number} or {array} $newSizes   
	 */
	public function __construct($filePath){
		$this->verifyPath($filePath);
		$this->setImageData();
	}

	
	/**
	 * Obtenemos los datos de la imagen 
	 */
	private function setImageData(){
		try {
			$imageData = exif_read_data($this->filePath);
		
			$this->mimeType = $imageData['MimeType'];
			$this->nameOrigin = $imageData['FileName'];
			$this->widthOrigin = $imageData['COMPUTED']['Width'];
			$this->heightOrigin = $imageData['COMPUTED']['Height'];
			$this->sizeOrigin = $imageData['FileSize'];
			
			if (!array_key_exists($this->mimeType, $this->mimeTypeSupport))
				throw new Exception("The file is not an image");
					
		} catch (Exception $e) {
			echo $e->getMessage();
			exit;
		}
	}


	/**
	 * Setting the new Dimensions  (Optional)
	 */ 
	public function setDimensions($newWidth, $newHeight){
		//$this->isEmptyException($width);
		//$this->isEmptyException($height);
		
		$this->newWidth = $newWidth;
		$this->newHeight = $newHeight;		
	}


	/**
	 * Verify that the data is not empty, null, space, false, 
	 * @param {mixed} $val - Generic value
	 */ 
	// protected function isEmpty($val){
	// 	return empty($val) || FALSE != $val || '' != trim($val); 
	// }


	/**
	 * Throw an exception, if the data is empty or has some value 
	 * of $this->isEmpty($val)
	 * @param {mixed} $val
	 */ 
	// protected function isEmptyException(&$val){
	// 	try {
	// 		if ($this->isEmpty($val))	
	// 			throw new Exception('La variable $val es requerida');
				
	// 	} catch (Exception $e) {
	// 		echo $e->getMessage();
	// 		exit;
	// 	}
	// }


	/**
	 * Setting the new Path of image,if not exits the path, created it
	 * 
	 * @param {string} $path
	 */
	public function setNewPath($path){
		$this->newPath = $path;
	}

	/**
	 * Return the new Path of image
	 * 
	 * @return {string}
	 */
	public function getNewPath(){
		return $this->newPath;	
	}


	/*protected function viewPathPermit(){
		if (!file_exists($this->newPath)){
			mkdir($this->newPath);
		}
		$permitInOctal = sprintf('%o', fileperms($this->newPath));
	} */


	/**
	 * Create a new JPG Image
	 */ 
	protected function resizeJPEG(){
		$image = imagecreatefromjpeg($this->filePath);
		imagecopyresampled(
			$this->canvas, $image, 0, 0, 0, 0, 
			$this->widthOrigin,
			$this->$heightOrigin
		);
		
		imagejpeg($this->canvas, $nameFile.".jpg");
	}


	/**
	 * Create a new PNG Image
	 */ 
	protected function resizePNG(){
		imagesavealpha($this->canvas, true);
		$color = imagecolorallocatealpha(
			$canvas, 0, 0, 0, 127
		);
		imagefill($this->canvas, 0, 0, $color);
		

		$img = imagecreatefrompng($this->filePath);
		imagecopyresampled(
			$this->canvas, $img, 0, 0, 0, 0, 
			$this->newWidth, $this->newHeight	
		);
		
		imagepng($canvas, $nameFile.".png");*/
	}


	/**
	 * Create a new GIF Image
	 */ 
	protected function resizeGIF(){
		$image = imagecreatefromgif($this->filePath);
		imagecopyresampled(
			$this->canvas, 
			$image, 0, 0, 0, 0, 
			$this->newWidth
			$this->newHeight
		);
		imagegif($canvas,$nameFile.".gif");
	}


	/**
	 * New dimensions by percentage
	 * @param {number} $percent
	 */	
	public function setWithPercent($percent){
		try {
			if ($percent < 0 && $percent > 1)
				throw new Exception(
					"Percentage must be a decimal between 0 - 1"
				);
			
			$this->newWidth = $this->widthOrigin * $percent;
			$this->newHeight = $this->heightOrigin * $percent;

		} catch (Exception $e) {
			echo $e->getMessage();
			exit;
		}
	}

}


?>