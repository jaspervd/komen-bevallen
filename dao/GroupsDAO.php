<?php
require_once __DIR__ . '/DAO.php';
require_once __DIR__ . '/UsersDAO.php';
class GroupsDAO extends DAO
{
    public $usersDAO;

    public function __construct() {
        parent::__construct();
        $usersDAO = new UsersDAO();
    }

    public function selectById($id) {
        $sql = "SELECT * FROM `kb_groups` WHERE `id` = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        if ($stmt->execute()) {
            $group = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!empty($group)) {
                $group['users'] = $usersDAO->selectByGroupId($group['id']);
                return $group;
            }
        }

        return array();
    }

    public function selectByWeek($week) {
        $sql = "SELECT * FROM `kb_groups` WHERE `week` = :week";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':week', $week);
        if ($stmt->execute()) {
            $group = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!empty($group)) {
                $group['users'] = $usersDAO->selectByGroupId($group['id']);
                return $group;
            }
        }

        return array();
    }

    public function insert($week) {
        $sql = "INSERT INTO `kb_groups` (`week`) VALUES (:week)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':week', $week);
        if ($stmt->execute()) {
            return $this->selectById($this->pdo->lastInsertId());
        }

        return array();
    }
}
