<?php
require_once __DIR__ . '/DAO.php';
class RatingsDAO extends DAO
{
    public function selectById($id) {
        $sql = "SELECT * FROM `kb_ratings` WHERE `id` = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return array();
    }

    public function selectByGroupId($group_id) {
        $sql = "SELECT * FROM `kb_ratings` WHERE `group_id` = :group_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':group_id', $group_id);
        if ($stmt->execute()) {
            $ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($ratings)) {
                return $ratings;
            }
        }

        return array();
    }

    public function selectByUserId($user_id) {
        $sql = "SELECT * FROM `kb_ratings` WHERE `user_id` = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        if ($stmt->execute()) {
            $ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($ratings)) {
                return $ratings;
            }
        }

        return array();
    }

    public function selectByContenderId($contender_id) {
        $sql = "SELECT * FROM `kb_ratings` WHERE `contender_id` = :contender_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':contender_id', $contender_id);
        if ($stmt->execute()) {
            $ratings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($ratings)) {
                return $ratings;
            }
        }

        return array();
    }

    public function insert($user_id, $points_show, $points_baby, $points_partner, $contender_id, $group_id) {
        $sql = "INSERT INTO `kb_ratings` (`user_id`, `points_show`, `points_baby`, `points_partner`, `contender_id`, `group_id`) VALUES (:user_id, :points_show, :points_baby, :points_partner, :contender_id, :group_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':points_show', $points_show);
        $stmt->bindValue(':points_baby', $points_baby);
        $stmt->bindValue(':points_partner', $points_partner);
        $stmt->bindValue(':contender_id', $contender_id);
        $stmt->bindValue(':group_id', $group_id);
        if ($stmt->execute()) {
            return $this->selectById($this->pdo->lastInsertId());
        }

        return array();
    }
}
