<?php
require_once __DIR__ . '/DAO.php';
class UsersDAO extends DAO {
	public function selectById($id) {
		$sql = "SELECT * FROM `cl_cheers` WHERE `id` = :id";
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

		return false;
	}
}