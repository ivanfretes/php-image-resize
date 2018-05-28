<?

require '../src/image-resize.php';

$path = './image-origin';
$d = dir($path);

$i = 0;
while (false !== ($entry = $d->read())) {
	if (is_file("$path/$entry")){
		$i++;
		$image = new ImageResize("$path/$entry");
		$image->setWithHeight(300);
		$image->setNewName("bwm-".$i);
		$image->resize();
		var_dump($entry."\n");
	}
}
	
$d->close();
//echo $image->getNewFilePath();
?>