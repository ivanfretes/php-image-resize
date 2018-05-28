<?
/**
 * Example of migrate /folder-z/folder-y/file-name.txt to field in a table
 * 
 * @example /folder-z/folder-y/file-name.txt => whatever/file-name.txt
 * 
 * @
 */

require '../src/path-migrate.php';
require './util/database/conn.php';

PathMigrate::setPathToSQL(array(
	'path' => , 
	'path_migration' => 'images/uploads'
));
?>