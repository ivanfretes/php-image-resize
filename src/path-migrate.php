<?

/**
 * Class that allows, Migrate files to SQL, for any database
 */

class PathMigrate {

	// If produce an error, when execute a query
	protected $err_execute = FALSE;

	/**
	 * @var mixed - Is an array with the configuration path
	 *   : 'title_case' => Ucwords boolean
	 * 	 : 'path' => It is the current path
	 *   : 'path_migration'=>It is the new Path, if empty is equalt to path 
	 *   : 'tablename' => Name of table of the database
	 *   : 'field_reference' => Is the field for compare, and prepare query
	 */
	protected $configuration = array(
		'title_case' => FALSE, 
		'path' => './',
		'path_migration' => '../images/resized',
		'tablename' => NULL,
		'field_reference' => 'field_reference'
	);


	/**
	 * @var array - Is an array data to connect PDO
	 */
	protected $conn = array(
		'driver' => 'mysql',
		'host' => 'localhost',
		'user' => NULL,
		'password' => NULL,
		'database' => NULL
	);


	// Db Instance
	protected $db;


	/**
	 * Set up the database connexion
	 * @param array $db - Features db connexion
	 */
	public function connDb($conn = array()){
		foreach ($conn as $key => $value) {
			$this->conn[$key] = $conn[$key];
		}

		$this->db = new PDO(
			"{$this->conn['driver']}:
			 host={$this->conn['host']};
			 dbname={$this->conn['database']}", 
			 "{$this->conn['user']}",
			 "{$this->conn['password']}"
		);
	}	


	/**
	 * @var array That is current files and dirs
	 */
	protected $dirs = [];


	/**
	 * @var array This is a new values ontained from the $dirs
	 */
	protected $newValues = [];


	/**
	 * @param mixed $configuration - Set up config the migration
	 */
	public function setConfig($configuration = array()){
		foreach ($configuration as $key => $value) {
			$this->configuration[$key] = $configuration[$key];
		}
		rtrim($this->configuration['path_migration']);

		$this->setDirs();
	}


	/**
	 * Scandir and update the current dirs
	 */
	protected function setDirs(){
		$dirs = scandir($this->configuration['path']);
		array_shift($dirs);
		array_shift($dirs);
		
		$this->dirs = $dirs;
	}


	/**	
	 * Actualiza los nombre de path para subir a la base de datos
	 * mc-donalds -> Mc Donalds
	 */
	public function setFieldNameSQL($configuration = array()) {
		$this->setConfig($configuration);

		foreach ($this->dirs as $fileName) {
			// Remove the extension in filename
			$fileNameWithoutExtension = preg_replace(
				'/\\.[^.\\s]{3,4}$/', '', $fileName
			);

			// Replace '-' or '_' with space ' ' 
			$newFileName = preg_replace(
				'/(_|-)+/', ' ', $fileNameWithoutExtension
			);
			
			if ($this->configuration['title_case'])
				$newFileName = ucwords($newFileName);

			array_push($this->newValues, array(
				'data_reference' => $fileNameWithoutExtension,
				'new_data' => $newFileName
			));
		}
	}



	// Retorna los valores con el path a ser migrados en el sql
	// /home/file/archivo-data.jpg
	public function setPathToSQL($configuration = array()){
		$this->setConfig($configuration);
		
		foreach ($this->dirs as $fileName) {
			// Remove the extension in filename
			$fileNameWithoutExtension = preg_replace(
				'/\\.[^.\\s]{3,4}$/', '', $fileName
			);


			array_push($this->newValues, array(
				'data_reference' => $fileNameWithoutExtension,
				'new_data' => $this->configuration['path_migration'].'/'
							  .$fileName
			));

		}
	}


	public function getNewValues(){
		return $this->newValues;
	}


	public function insert($fieldname){
		$tablename = $this->configuration['tablename'];
		$fieldReference = $this->configuration['field_reference'];

		try {
			// Prepare the SQL query
			$prepare = $this->db->prepare(
				"INSERT INTO $tablename ($fieldname, $fieldReference) 	
				 VALUES (:data, :data2)");

			foreach ($this->newValues as $key) {
				$prepare->bindParam(':data', $key['new_data']);
				$prepare->bindParam(':data2', $key['data_reference']);
				
				if (!$prepare->execute()){
					throw new Exception(
						"The reference of the field is in another record", 1
					);
				}
			}	
		} catch (Exception $e) {
			echo $e->getMessage();	
		}
	}


	public function update($fieldname){
		$tablename = $this->configuration['tablename'];
		$fieldCondition = $this->configuration['field_reference'];
		
		try {	
			$prepare = $this->db->prepare("
				UPDATE $tablename
				SET $fieldname = :data
				WHERE POSITION($fieldCondition IN :data2) != 0" 
			);

			foreach ($this->newValues as $key) {
				$prepare->bindParam(':data', $key['new_data']);
				$prepare->bindParam(':data2', $key['data_reference']);

				if (!$prepare->execute()){
					$this->err_execute = TRUE;
				}
			}

		} catch (Exception $e) {
			echo $e->getMessage();
		}

		$this->cathErrExecuteQuery();
	}


	/**
	 * Error al ejecutar consulta
	 */
	public function cathErrExecuteQuery(){
		if ($this->err_execute) {
			throw new Exception(
				"Something went wrong", 1
			);
		}
	}

}


?>