<?

class PathMigrate {

	protected static $configuration = array(
		'title_case' => FALSE, 
		'path' => './',
		'path_migration' => ''
	);

	protected static setConfiguration($configuration){
		if (isset($configuration['path_migration'] )){
			$configuration['path_migration'] = $configuration['path'];
		}

		$this->configuration = $configuration;
	}



	// Actualiza los nombre de path para subir a la base de datos
	// mc-donalds -> Mc Donalds
	public static function setFieldNameSQL($configuration = NULL)
	{
		$this->setConfiguration($configuration);

		$dataTmp = [];
		$dirStream = scandir($this->configuration['path']);
		$arrTmp['dir_stream'] = $dirStream;

		foreach ($dirStream as $fileName) {
			if ($fileName != '.' && $fileName != '..'){
				$nameTmp = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
				$nameTmp = preg_replace('/(_|-)+/', ' ', $nameTmp);
					
				/**
				 * Arreglo temporal que almacena, los valores del array
				 * original como los del generado
				 */ 

				// Mover a otra funcion
				if ($configuration['title_case'])
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
		$this->setConfiguration($configuration);

		$pathData = [];
		$dirStream = scandir($path);
		foreach ($dirStream as $fileName) {
			if ($fileName != '.' && $fileName != '..'){
				$fileName = rtrim($fileName, '/');
				$pathMigration = $this->configuration['path_migration'];
				array_push($pathData, $pathMigration.'/'.$fileName);
			}
		}

		return $pathData;
	}
}


?>