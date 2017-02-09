<?
	require "Resizeimg.php"; 


	$listMarcas = array('bmw' => 
						array('Serie 1' => 'http://gasp.com/wp-content/uploads/2015/06/bmw-serie-1-2015_15.png',
							  'Serie 2' => 'http://gasp.com/wp-content/uploads/2015/06/2014-bmw-2-series-m235i.png'
							), 
					'Mercedes Benz' => 
						array('A' => 'http://st.motortrend.com/uploads/sites/10/2016/10/2017-mercedes-benz-b-class-electric-drive-mini-mpv-angular-front.png',
							  'C' => 'http://www.mbzlongbeach.com/photo/izmo_tlc/sscusa/2016/16mercedes/16mercedescclssac3004t/mercedes_16cclssac3004t_angularfront_polarwhite.png' ));

	/**/

	foreach ($listMarcas as $marca => $listModelos) {
		foreach ($listModelos as $modelo => $url) {
			$img = new PHPResizeImg\ResizeImg($url, array(350,400));
			//$img->setPathImg("img/hola");

			$img->assignName($marca."_".$modelo);
			$img->resizeImg();?>
			<img src="<? //$img->getPathImg()."/".;?>">
		<? }
	}
	echo "Listo";

?>

