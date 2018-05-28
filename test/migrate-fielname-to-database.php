<?
/**
 * Example of migrate file-name to field in a table
 * 
 * @example field-name.txt => Field Name
 * @example folder-name => Folder Name
 */
require '../src/path-migrate.php';
require './util/database/database.php';


$migrate = PathMigrate::setFieldNameSQL([
	'path' => '/var/www/html/Test/laravel/cero-app/public/images/logo_representante',
	'title_case' => TRUE
]);


foreach ($migrate as $recordDataTmp) {
	echo $recordDataTmp['word_use_in_sql'];
}
?>