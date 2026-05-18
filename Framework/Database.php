<?php

namespace Framework;
use PDO;

class Database
{
	public $conn;

	/**
	 * Database constructor.
	 *
	 * @param array $config
	 */
	public function __construct($config)
	{
		$dsn = "mysql:host={$config['host']};
				port={$config['port']};
				dbname={$config['dbname']}";

		$options = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
		];

		try {
			$this->conn = new PDO($dsn, $config['username'], $config['password'], $options);

			// echo 'connected';
		} catch (PDOException $e) {
			throw new Exception("Database connection failed: " . $e->getMessage());
		}
	}

	/**
	 * Execute a SQL query and return the results.
	 *
	 * @param string $query
	 * @return PDOStatement
	 * @throws Exception
	 */
	public function query($query,  $params=[])
	{
		try {
			$stmt = $this->conn->prepare($query);
			//bind params
			foreach($params as $param => $value){
				$stmt->bindValue(':'.$param, $value);
			}
			$stmt->execute();
			return $stmt;
		} catch (PDOException $e) {
			throw new Exception("Query failed: " . $e->getMessage());
		}
	}
}