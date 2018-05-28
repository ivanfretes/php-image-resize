<?
$db = new PDO("mysql:host=localhost;dbname=db", 'user','pass');


function migratePath($prepare, $dataListTmp){
	$prepare->bindParam(':data', $dataName);

	$i = 0;
	foreach ($dataListTmp as $dataName) {
		if (!$prepare->execute()){
			echo "Problema al ejecutar la consulta!";
			exit;
		}
		$i++;
	}

	echo "Registros Insertados". +$i;
}

?>
