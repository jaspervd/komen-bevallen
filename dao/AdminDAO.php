<?php
require_once __DIR__ . '/DAO.php';
class AdmindAO extends DAO {
	public function select() {
		$sql = "SELECT * FROM `kb_admin` LIMIT 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function update($date, $finished) {
		$sql = "UPDATE `kb_admin` SET `date` = :date, `finished` = :finished";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':date', $date);
		$stmt->bindValue(':finished', $finished);
		if($stmt->execute()) {
			return $this->select();
		}

		return array();
	}

	public function insert($date, $finished) {
		$sql = "INSERT INTO `kb_admin` (`date`, `finished`) VALUES (:date, :finished)";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindValue(':date', $date);
		$stmt->bindValue(':finished', $finished);
		if($stmt->execute()) {
			return $this->select();
		}

		return array();
	}
}