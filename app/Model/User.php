<?php

namespace App\Model;

use PDO;
use VC\Model;

class User extends Model {

	protected function validate( array $data ): array|false {
		if ( ! empty( $data["email"] && ! empty( $data["pass"] ) ) ) {

			return [
				'email' => $data['email'],
				'pass'  => $data['pass'],
			];

		}
		$this->addError( "empty", "Please fill all fields" );
		return false;
	}

	public function getUser(array $data) : array|bool {
		$pdo = $this->db->connect();

		$data = $this->validate($data);

		if ( ! $data) {
			return false;
		}

		$sql = "SELECT *
            FROM `{$this->getTableName()}`
            WHERE `email` = :email";

		$stmt = $pdo->prepare( $sql );
		$stmt->bindValue( ':email', $data['email'], PDO::PARAM_STR );
		$stmt->execute();

		$result = $stmt->fetch( PDO::FETCH_ASSOC );

		if(empty($result)) {
			$this->addError( "failed", "Your input does not match our records" );
			return false;
		}

		return $result;
	}


}