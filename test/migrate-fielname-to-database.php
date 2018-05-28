<?
/**
 * Example of migrate file-name to field in a table
 * 
 * @example field-name.txt => Field Name
 * @example folder-name => Folder Name
 */
require '../src/path-migrate.php';
require './util/database/conn.php';

/**
 * Return the old path name through the $migrate['original_name'] and
 * the new path name through the $migrate['word_use_in_sql']
 */
$migrate = PathMigrate::setFieldNameSQL(
	'/var/www/html/Test/laravel/cero-app/public/images/logo_representante',
	TRUE
);


var_dump($migrate);
?>