<?php
require_once __DIR__ . '/DAO.php';
class PhotosDAO extends DAO
{
    public function selectById($id) {
        $sql = "SELECT * FROM `kb_photos` WHERE `id` = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return array();
    }

    public function selectByGroupId($group_id) {
        $sql = "SELECT * FROM `kb_photos` WHERE `group_id` = :group_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':group_id', $group_id);
        if ($stmt->execute()) {
            $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($photos)) {
                return $photos;
            }
        }

        return array();
    }

    public function selectByUserId($user_id) {
        $sql = "SELECT * FROM `kb_photos` WHERE `user_id` = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        if ($stmt->execute()) {
            $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($photos)) {
                return $photos;
            }
        }

        return array();
    }

    public function selectByDay($day) {
        $sql = "SELECT * FROM `kb_photos` WHERE `day` = :day";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':day', $day);
        if ($stmt->execute()) {
            $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($photos)) {
                return $photos;
            }
        }

        return array();
    }

    public function insert($user_id, $group_id, $photo_url, $day) {
        $sql = "INSERT INTO `kb_photos` (`user_id`, `group_id`, `photo_url`, `day`) VALUES (:user_id, :group_id, :photo_url, :day)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':user_id', $user_id);
        $stmt->bindValue(':group_id', $group_id);
        $stmt->bindValue(':photo_url', $photo_url);
        $stmt->bindValue(':day', $day);
        if ($stmt->execute()) {
            return $this->selectById($this->pdo->lastInsertId());
        }

        return array();
    }
}
