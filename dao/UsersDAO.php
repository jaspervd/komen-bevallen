<?php
require_once __DIR__ . '/DAO.php';
class UsersDAO extends DAO {
	public function selectById($id) {
		$sql = "SELECT * FROM `kb_users` WHERE `id` = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function authenticate($email, $password) {
		$sql = "SELECT * FROM `kb_users` WHERE `email` = :email";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':email', $email);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($user)) {
			if (password_verify($password, $user['password'])) {
				return $user;
			}
		}

		return array();
	}

	public function register($email, $password) {
		$sql = "INSERT INTO `kb_users` (`email`, `password`) VALUES (:email, :password)";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':email', $email);
		$stmt->bindValue(':password', Util::encrypt($password));
		if($stmt->execute()) {
			return $this->selectById($this->pdo->lastInsertId());
		}

		return array();
	}

	public function checkExistingEmail($email) {
		$sql = "SELECT `id` FROM `kb_users` WHERE `email` = :email";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':email', $email);
		$stmt->execute();

		return ($stmt->fetch(PDO::FETCH_ASSOC));
	}
}