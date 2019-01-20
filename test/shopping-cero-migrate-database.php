<?
//require '../src/image-resize.php';

if (isset($_GET['submit'])){
	require '../src/path-migrate.php';

	migrateSql();
}


function migrateSql(){
	$path = '/var/www/html/Test/image-resize/images/resized/version_icono';

	$pathMigrate = new PathMigrate();

	$pathMigrate->connDb( array(
		'user' => 'root',
		'password' => 'admin123',
		'database' => 'cero_app'
	));


	$pathMigrate->setConfig(array(
		'path' => $path,
		'path_migration' => 'images/upload',
		'tablename' => 'vehicle_versions',
		'field_reference' => 'version_path'
	));


	//$pathMigrate->setFieldNameSQL();
	//$pathMigrate->update('representante_path');


	$pathMigrate->setPathToSQL();
	$pathMigrate->update('version_icon');
}

?>