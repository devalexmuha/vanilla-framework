<?php

namespace App\Model;

use App\Database;
use PDO;

class Page {

	public function __construct(private Database $db) {}

	public function getAll(): array {
		$pdo = $this->db->getConnection();
		$stmt = $pdo->prepare( 'SELECT * FROM `product`' );
		$stmt->execute();
		return $stmt->fetchAll();
	}
}