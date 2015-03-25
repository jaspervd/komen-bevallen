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

	public function register($email, $password, $mother, $partner, $duedate, $street, $streetnr, $city, $telephone) {
		$sql = "INSERT INTO `kb_users` (`email`, `password`, `mother`, `partner`, `duedate`, `street`, `streetnr`, `city`, `telephone`) VALUES (:email, :password, :mother, :partner, :duedate, :street, :streetnr, :city, :telephone)";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':email', $email);
		$stmt->bindValue(':password', Util::encrypt($password));
		$stmt->bindValue(':mother', $email);
		$stmt->bindValue(':partner', $partner);
		$stmt->bindValue(':duedate', $duedate);
		$stmt->bindValue(':street', $street);
		$stmt->bindValue(':streetnr', $streetnr);
		$stmt->bindValue(':city', $city);
		$stmt->bindValue(':telephone', $telephone);
		if($stmt->execute()) {
			return $this->selectById($this->pdo->lastInsertId());
		}

		return array();
	}
}