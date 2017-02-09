<?
	require "Resizeimg.php"; 


	$img = new PHPResizeImg\ResizeImg("http://www.bmw.com.mx/content/dam/bmw/common/all-models/m-series/m4-coupe/2014/m4-gts/m4-gts-driving-large-teaser-.jpg/jcr:content/renditions/cq5dam.resized.img.1680.large.time1447949538576.jpg", array(350,400));
	//$img->setPathImg("img/hola");
	$img->assignName("bmw_serie_1_250x300");
	$img->resizeImg();

?>

<img src="<? echo $img->getPathImg();?>/bmw_serie_1_250x300.jpg">