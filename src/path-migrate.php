<?

class PathMigrate {

	protected static $configuration = array(
		'title_case' => FALSE, 
		'path' => './',
		'path_migration' => ''
	);

	protected static function setConfiguration($configuration){
		if (!array_key_exists('path_migration',$configuration)){
			$configuration['path_migration'] = $configuration['path'];
		}

		self::$configuration = $configuration;
	}



	// Actualiza los nombre de path para subir a la base de datos
	// mc-donalds -> Mc Donalds
	public static function setFieldNameSQL($configuration = NULL)
	{
		self::setConfiguration($configuration);

		$dataTmp = [];
		$dirStream = scandir(self::$configuration['path']);

		foreach ($dirStream as $fileName) {
			if ($fileName != '.' && $fileName != '..'){
				$nameTmp = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
				$nameTmp = preg_replace('/(_|-)+/', ' ', $nameTmp);
					
				if (self::$configuration['title_case'])
					$nameTmp = ucwords($nameTmp);

				array_push($dataTmp, array(
					'original_name' => $fileName,
					'word_use_in_sql' => $nameTmp
				));
			}
		}

		return $dataTmp;
	}



	// Retorna los valores con el path a ser migrados en el sql
	// /home/file/archivo-data.jpg
	public static function setPathToSQL($configuration = NULL){
		self::setConfiguration($configuration);

		$pathData = [];
		$dirStream = scandir(self::$configuration['path']);
		foreach ($dirStream as $fileName) {
			if ($fileName != '.' && $fileName != '..'){
				$fileName = rtrim($fileName, '/');
				$pathMigration = self::$configuration['path_migration'];
				array_push($pathData, $pathMigration.'/'.$fileName);
			}
		}

		return $pathData;
	}


	/**
	 * Por el momento, solo me interesa que inserte un dato por registro
	 * 
	 * @param string $prepare, "$db->prepare"
	 * @param array $dataList, Conjunto de Datos a ser insertados
	 */
	public static function migrate($prepare, $dataList){
		$i = 0;
		$i_err = 0;
		foreach ($dataList as $paramYield => $paramVal) {
			$prepare->bindParam($paramYield, $paramVal);
			
			if (!$prepare->execute()){
				echo "Problem to run the query!";
				$i_err++;
			}
			$i++;
		}

		echo "Number of errors in the records migrated - ($i_error of $i)";
	}
}


?>