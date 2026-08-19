<?php

declare( strict_types=1 );

namespace VC;

use PDO;
use App\Database;
use VC\Exceptions\PageNotFoundException;

abstract class Model {

	public function __construct( private readonly Database $db ) {
	}

	protected string $table;

	private function getTableName(): string {
		if ( ! empty( $this->table ) ) {

			return $this->table;

		}

		$parts = explode( "\\", $this::class );

		return strtolower( array_pop( $parts ) ) . 's';
	}

	public function getAll(): array {

		$pdo = $this->db->connect();

		$sql = "SELECT * FROM `{$this->getTableName()}`";

		$stmt = $pdo->query( $sql );

		$results = $stmt->fetchAll( PDO::FETCH_ASSOC );

		if(empty($results)) {
			throw new PageNotFoundException("No results found for {$this->getTableName()}");
		}

		return $results;
	}

	public function getById( string $id ): array|bool {
		$pdo = $this->db->connect();

		$sql = "SELECT *
                FROM {$this->getTableName()}
                WHERE id = :id";

		$stmt = $pdo->prepare( $sql );

		$stmt->bindValue( ':id', $id, PDO::PARAM_INT );

		$stmt->execute();

		$results = $stmt->fetch( PDO::FETCH_ASSOC );

		if(empty($results)) {
			throw new PageNotFoundException("No results found for {$this->getTableName()}");
		}

		return $results;
	}

	public function getByCol( string $column, string $value ): array|bool {

		$allowed = [ 'slug', 'name', 'id' ];
		if ( ! in_array( $column, $allowed, true ) ) {
			throw new \InvalidArgumentException( "Invalid column: {$column}" );
		}

		$pdo = $this->db->connect();

		$sql = "SELECT *
            FROM `{$this->getTableName()}`
            WHERE `{$column}` = :value";

		$stmt = $pdo->prepare( $sql );
		$stmt->bindValue( ':value', $value, PDO::PARAM_STR );
		$stmt->execute();

		$results = $stmt->fetch( PDO::FETCH_ASSOC );

		if(empty($results)) {
			throw new PageNotFoundException("No results found for {$this->getTableName()}");
		}

		return $results;
	}

}