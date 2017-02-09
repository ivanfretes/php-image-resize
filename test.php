<?
	require "Resizeimg.php"; 


	$img = new PHPResizeImg\ResizeImg("http://www.bmw.com.mx/content/dam/bmw/common/all-models/m-series/m4-coupe/2014/m4-gts/m4-gts-driving-large-teaser-.jpg/jcr:content/renditions/cq5dam.resized.img.1680.large.time1447949538576.jpg", array(225,125));
	//$img->setPathImg("img/hola");
	//$img->assignName("nameTest");
	$img->resizeImg();
?>