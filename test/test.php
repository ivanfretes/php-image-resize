<?

require '../src/image-resize.php';

$image = new ImageResize('./image-origin/BMW-X5-PNG-Clipart.png');
$image->setWithHeight(300);
$image->resize();

?>