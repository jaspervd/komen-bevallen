<?php
require_once __DIR__ . '/DAO.php';
class UsersDAO extends DAO {
	public function selectById($id) {
		$sql = "SELECT * FROM `kb_pregnancies` WHERE `id` = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function insert($user_id, $mother, $partner, $type, $duedate, $photo_url) {
		$sql = "INSERT INTO `kb_pregnancies` (`user_id`, `mother`, `partner`, `type`, `duedate`, `photo_url`) VALUES (:user_id, :mother, :partner, :type, :duedate, :photo_url)";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':user_id', $user_id);
		$stmt->bindValue(':mother', $mother);
		$stmt->bindValue(':partner', $partner);
		$stmt->bindValue(':type', $type);
		$stmt->bindValue(':duedate', $duedate);
		$stmt->bindValue(':photo_url', $photo_url);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		if(!empty($user)) {
			return $user;
		}

		return array();
	}
}