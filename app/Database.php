<?php

declare( strict_types=1 );

namespace App;

use PDO;

class Database {
	public function __construct(
		private readonly string $host,
		private readonly string $dbName,
		private readonly string $username,
		private readonly string $password
	) {
	}

	private null|PDO $pdo = null;

	public function connect(): PDO {
		if ( $this->pdo === null ) {
			$this->pdo = new PDO( "mysql:host=$this->host;dbname=$this->dbName;charset=utf8mb4", "$this->username",
				"$this->password", [
					PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
					PDO::ATTR_TIMEOUT            => 5
				] );
		}

		return $this->pdo;
	}

}