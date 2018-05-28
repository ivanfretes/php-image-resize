<?


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
	protected $newName = 'image-resized';
	protected $newPath = '../images/resized';
	protected $newWidth;
	protected $newHeight;
	protected $newFilePath;

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
	protected $fileOpen;


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


	/**
	 * Update the file data
	 */ 
	protected function setFileData(){
		$this->sizeOrigin = filesize($this->filePath);
		$this->nameOrigin = basename($this->filePath);
		$this->fileOpen = fopen($this->filePath, 'r');
		$fileData = fread($this->fileOpen, $this->sizeOrigin);
	}


	public function resize(){
		$mime = $this->mimeType;
		$resizeByFormat = $this->mimeTypeSupport[$mime];
		$this->newFilePath = "$this->newPath/$this->newName";

		header("Content-type:".$mime);
		$this->canvas = imagecreatetruecolor(
			$this->newWidth, $this->newHeight
		);

		$this->$resizeByFormat();
		fclose($this->fileOpen); 
	}


	/**
	 * Updated the name of the image. 
	 * (*) Default replacement dash instead white space key
	 * 
	 * @param {string} $char
	 */
	public function removeWhiteSpace($char = '-'){
		$this->newName = str_replace(
			' ', $char, $this->newName
		);
	}


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
		$this->setFileData();
		$this->setImageData();
	}

	
	/**
	 * Obtenemos los datos de la imagen 
	 */
	private function setImageData(){
		try {
			$imageData = getimagesize($this->filePath);

			$this->mimeType = $imageData['mime'];
			$this->widthOrigin = $imageData[0];
			$this->heightOrigin = $imageData[1];
			
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
	 * Setting the new Path of image,if not exits the path, created it
	 * 
	 * @param {string} $path
	 */
	public function setNewPath($path){
		$this->newPath = rtrim($path,'/','');
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
		echo "string";
		$image = imagecreatefromjpeg($this->filePath);
		imagecopyresampled(
			$this->canvas, $image, 0, 0, 0, 0, 
			$this->newWidth,
			$this->newHeight,
			$this->widthOrigin,
			$this->heightOrigin
		);
		imagejpeg($this->canvas, "$this->newFilePath.jpg");
	}


	/**
	 * Create a new PNG Image
	 */ 
	protected function resizePNG(){
		imagesavealpha($this->canvas, true);
		$color = imagecolorallocatealpha(
			$this->canvas, 0, 0, 0, 127
		);
		imagefill($this->canvas, 0, 0, $color);
		

		$image = imagecreatefrompng($this->filePath);
		imagecopyresampled(
			$this->canvas, $image, 0, 0, 0, 0, 
			$this->newWidth, 
			$this->newHeight,
			$this->widthOrigin,
			$this->heightOrigin	
		);
		
		imagepng($this->canvas, "$this->newFilePath.png");
	}


	public function setNewName($newName){
		$this->newName = $newName;
	}


	public function getNewFilePath(){
		return $this->newFilePath;
	}


	/**
	 * Create a new GIF Image
	 */ 
	protected function resizeGIF(){
		$image = imagecreatefromgif($this->filePath);
		imagecopyresampled(
			$this->canvas, 
			$image, 0, 0, 0, 0, 
			$this->newWidth,
			$this->newHeight
		);
		imagegif($canvas, "$this->newFilePath.gif");
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