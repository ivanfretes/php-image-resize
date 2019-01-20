<?
/**
 * 
 * 
 * Require de $_GET['submit'] && $_GET['coincidence']
 * 
 * Para las portadas
	*portada (del modelo en general)
	*exterior_portada
	*interior_portada

Para los interiores
	*interior1
	*interior2
	*interior3
	*interior4

Para los interiores
	*exterior1
	*exterior2
	*exterior3
	*exterior4

Para el icono
	*icono

para los colores 
	*color1
	*color2
	*color3


Utilizamos los slugs_para obtener el mismo nombre que las carpetas

 */



require '../src/image-resize.php';

// Base a donde migrar los datos
$basePath = '/var/www/html/Test/image-resize/test/util/shoppingcero_marcas';


if (isset($_GET['submit'])){
	getMarcas($basePath);
}


// General el listado de marcas
function getMarcas($basePath){
	$basePath = rtrim($basePath, '/');
	$dirs = scandir($basePath);

	array_shift($dirs);
	array_shift($dirs);


	foreach ($dirs as $dir) {
		$marcaPath = $basePath.'/'.$dir; 
		if (is_dir($marcaPath))
			getModelos($dir, $marcaPath);

		echo "\n -- \n";
	}	

}



// Genera listado de modelos, por marca
function getModelos($marca, $basePath){

	$basePath = rtrim($basePath, '/');
	$dirs = scandir($basePath);
	array_shift($dirs);
	array_shift($dirs);


	foreach ($dirs as $dir) {
		$modeloPath = $basePath.'/'.$dir;
		if (is_dir($modeloPath)){
			$marca_modelo = $marca."_".$dir;
			getImages($marca_modelo, $modeloPath);
		}

	}

}



// Genera listado de imagenes, de modelos y versines
// Modificar la comparación del strpos, por lo buscado
function getImages($marca_modelo, $basePath){

	$basePath = rtrim($basePath, '/');
	$dirs = scandir($basePath);
	array_shift($dirs); // .
	array_shift($dirs); // ..
	
	foreach ($dirs as $dir) {
		$imagePath = $basePath.'/'.$dir;
		if (!is_dir($imagePath) && $dir != 'Thumbs.db'){


			if (isset($_GET['folder'])){
				if (strpos($dir, $_GET['coincidence']) === 0){
					$imageName = $marca_modelo.'_'.$dir;
					resizeImage($imageName, $imagePath);
				}	
			}
		}
	}

}


/**
 * Modifica la ruta
 */
function resizeImage($name, $path){
	$image = new ImageResize($path);

	// Actualizar en base al ancho
	$image->setWithWidth(800);

	// Solo actualiza el nombre
	$image->setNewFileName($name);


	// Actualiza el path
	$image->setNewPath('../images/resized/'.$_GET['folder']);


	// Redimensiona las caracteristicas
	$image->resize();

}




// Conexion a la base de datos
function getConnPDO(){
	$db = new PDO("mysql:host=localhost;dbname=cero_app", 
		 "root",
		 "admin123"
	);

	return $db;
}


// Path donde se migro el archivo
$pathMigration = '';

function insertVehicle($path){
	$db = getConnPDO();
	$db->prepare('INSERT INTO vehicles(vehicle_image, vehicle_)');
}


// Retorna el ID, de la marca que es referencia
function getReferenciaMarca(){

}

?>