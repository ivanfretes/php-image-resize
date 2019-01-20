<?

/**
 * Redefine las relaciones generadas, en base al slug, de cada archivo
 */


// Retorna todos los datos de la tabla padre
function getParentRecords($table){
	$db = getConnPDO();

	$query = $db->query("SELECT * FROM $table");
	$execute = $query->execute();
	$results = $execute->fetchAll();
	return $results;
}


// Agregar como decorador
function setChildRecords($table){

}

/**
 * Mejorar a closure
 */
function updateParentRecords($table, $field, $parentRecords){
	$db = getConnPDO();
	$prepare = $db->prepare("UPDATE $table SET $field = :field");

	foreach ($parentRecords as $record) {
		$prepare->execute([':field' => $record['field_reference']])
	}
	$prepare->close();
}

// Conexion a la base de datos
function getConnPDO(){
	$db = new PDO("mysql:host=localhost;dbname=cero_app", 
		 "root",
		 "admin123"
	);

	return $db;
}


?>