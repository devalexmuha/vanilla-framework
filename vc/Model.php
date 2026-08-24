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

	public function getByCol( string $column, string $value ): array {

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

	public function getUser(string $value, string $column = 'email') : array|bool {
		$pdo = $this->db->connect();

		$allowed = [ 'email', 'name', 'id' ];
		if ( ! in_array( $column, $allowed, true ) ) {
			throw new \InvalidArgumentException( "Invalid column: {$column}" );
		}

		$sql = "SELECT *
            FROM `{$this->getTableName()}`
            WHERE `{$column}` = :value";

		$stmt = $pdo->prepare( $sql );
		$stmt->bindValue( ':value', $value, PDO::PARAM_STR );
		$stmt->execute();

		$results = $stmt->fetch( PDO::FETCH_ASSOC );

		if(empty($results)) {
			return false;
		}

		return $results;
	}

	public function insert( array $data ): bool {
		$columns = implode(", ", array_keys($data));
		$placeholders = implode(", ", array_fill(0, count($data), "?"));

		$sql = "INSERT INTO {$this->getTableName()} ($columns)
                VALUES ($placeholders)";

		$conn = $this->db->connect();

		$stmt = $conn->prepare($sql);

		$i = 1;

		foreach ($data as $value) {

			$type = match(gettype($value)) {
				"boolean" => PDO::PARAM_BOOL,
				"integer" => PDO::PARAM_INT,
				"NULL" => PDO::PARAM_NULL,
				default => PDO::PARAM_STR
			};

			$stmt->bindValue($i++, $value, $type);

		}

		return $stmt->execute();
	}

	public function delete(string $id): bool
	{
		$sql = "DELETE FROM {$this->getTableName()}
                WHERE id = :id";

		$conn = $this->db->connect();

		$stmt = $conn->prepare($sql);

		$stmt->bindValue(":id", $id, PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function update(string $id, array $data): bool
	{

		$sql = "UPDATE {$this->getTableName()} ";

		unset($data["id"]);

		$assignments = array_keys($data);

		array_walk($assignments, function (&$value) {
			$value = "$value = ?";
		});

		$sql .= " SET " . implode(", ", $assignments);

		$sql .= " WHERE id = ?";

		$conn = $this->db->connect();

		$stmt = $conn->prepare($sql);

		$i = 1;

		foreach ($data as $value) {

			$type = match(gettype($value)) {
				"boolean" => PDO::PARAM_BOOL,
				"integer" => PDO::PARAM_INT,
				"NULL" => PDO::PARAM_NULL,
				default => PDO::PARAM_STR
			};

			$stmt->bindValue($i++, $value, $type);

		}

		$stmt->bindValue($i, $id, PDO::PARAM_INT);

		return $stmt->execute();
	}


}