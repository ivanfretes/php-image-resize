<?
	require "Resizeimg.php"; 


	$listMarcas = array('bmw' => 
						array('Serie 1' => 'http://pngimg.com/upload/bmw_PNG1706.png',
							  'Serie 2' => 'http://gasp.com/wp-content/uploads/2015/06/2014-bmw-2-series-m235i.png',
							  
							  'Serie 3' => 'http://www.freeiconspng.com/uploads/2012-in-3-series-bmw-tags-3-series-activehybrid-bmw-featured--19.png',
							  
							  'Serie 5' => 'http://www.bmwofflorence.com/assets/misc/12223/images/5series.png',
							  
							  'Serie 6' => 'http://www.bmw.com.ar/content/dam/bmw/common/all-models/6-series/gran-coupe/2014/model-card/BMW-6-Series-Gran-Coupe_ModelCard.png',
							  
							  'Serie 7' => 'http://www.freeiconspng.com/uploads/22nd-2012-in-7-series-bmw-tags-7-series-bmw-featured-background-color-8.png'
							), 
						'Mercedes Benz' => 
						array('A' => 'http://st.motortrend.com/uploads/sites/10/2016/10/2017-mercedes-benz-b-class-electric-drive-mini-mpv-angular-front.png',
							  'C' => 'http://www.mbzlongbeach.com/photo/izmo_tlc/sscusa/2016/16mercedes/16mercedescclssac3004t/mercedes_16cclssac3004t_angularfront_polarwhite.png' )

							);

	
	foreach ($listMarcas as $marca => $listModelos) {
		foreach ($listModelos as $modelo => $url) {

			// Resize 225 x 125
			$img = new PHPResizeImg\ResizeImg($url, array(225,125));
			$img->assignName($marca."_".$modelo."_"."225x125");
			$img->resizeImg();

			// Resize 1024 x 768
			$img = new PHPResizeImg\ResizeImg($url, array(1024,768));
			$img->assignName($marca."_".$modelo."_"."1024x768");
			$img->resizeImg();

		}
	}
	/*$url = 'http://images.webmakerx.net/Sites/Site20551/Picture/2011/April/Z4.PNG';
	$img = new PHPResizeImg\ResizeImg($url, array(225,125));
	//$img->setPathImg("img/hola");

	//$img->assignName("nameText");
	$img->resizeImg();*/
	echo "Listo";

?>

