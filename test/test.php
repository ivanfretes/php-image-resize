<?

require '../src/image-resize.php';

$image = new ImageResize('./image-origin/cq5dam.resized.img.1680.large.time1492418833349.jpg');
$image->setDimensions(300,400);
//$image->setNewPath('')
$image->resize();

?>