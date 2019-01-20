<?

require '../src/image-resize.php';

/**
 * 1. Instancia de Image resize, con el $path a ser redimensionado
 * 2. Asignar Configuraciones
 * 		2.1 Nuevo alto o nuevo ancho - Metodos distintos
 * 3. Redimensionar la imagen
 */


$path = '/var/www/html/Test/image-resize/test/util/logo_representante/timbo.jpeg';
$image = new ImageResize($path);

/**
 *  Opciones de redimensión de la imagen
 * 
 * 	$image->setDimensions($newWidth, $newHeight); - nuevo ancho y nuevo algo
 * 	$image->setWithHeight($newHeight); - ratio por el alto
 * 	$image->setWithWidth($newWidth);
 *  setWithPercent($percent)
 *
 *  --
 * 
 *  Opciones referente al nombre de la imagen
 * 
 * 	1. No asignar nombre por defecto guarda como image-resize.[x]
 *  2. $image->setNewFileName($newName); - Nuevo nombre de la imagen, no especificar formato
 * 	3. $image->setNewPath($newPath); - Nuevo destino de la imagen
 *  4. $image->notRenameFile(); conservar el nombre original
 */



// Actualizar en base al ancho
$image->setWithWidth(700);

// Solo pasar el nombre como parametro
//$image->setNewFileName('hola-mundo');


// Pasar como parametro el nuevo path, donde guardar la imagen
$image->setNewPath('../images/ts');


// Redimenciona
$image->resize();


?>