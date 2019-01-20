<?

/**
 * 1. Asignar datos de conexión a la base de datos
 * 2. Configuración de la migracion
 * 3. El tipo de migracion que se realizara
 * 		3.1 Migrar el path al sql (actual o nuevo), dependiendo de la config
 * 		3.2 Cambiar el nombre del archivo y migrar al sql 
 * 4. Insertar o actualizar elementos, indicando el campo a utilizar
 */
 
require '../src/path-migrate.php';

$pathMigrate = new PathMigrate();

$pathMigrate->connDb( array(
	'user' => 'root',
	'password' => 'admin123',
	'database' => 'cero_app'
));


$pathMigrate->setConfig(array(
	'path' => '~/image-origin',
	'path_migration' => 'images/resized',
	'tablename' => 'test',
	'field_reference' => 'nombre_imagen'
));


//$pathMigrate->setFieldNameSQL();
//$pathMigrate->update('representante_path');


$pathMigrate->setPathToSQL();
$pathMigrate->insert('representante_path');


?>