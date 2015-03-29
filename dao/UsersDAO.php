<?php
require_once __DIR__ . '/DAO.php';
class UsersDAO extends DAO
{
    public function selectById($id) {
        $sql = "SELECT * FROM `kb_users` WHERE `id` = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        if($stmt->execute()) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!empty($user)) {
                unset($user['password']);
                return $user;
            }
        }

        return array();
    }

    public function selectByGroupId($group_id) {
        $sql = "SELECT * FROM `kb_users` WHERE `group_id` = :group_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':group_id', $group_id);
        if($stmt->execute()) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($users)) {
                foreach($users as $key => $value) {
                    unset($users[$key]['password']);
                }
                return $users;
            }
        }

        return array();
    }

    public function authenticate($email, $password) {
        $sql = "SELECT * FROM `kb_users` WHERE `email` = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($user)) {
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }

        return array();
    }

    public function register($email, $password, $mother, $partner, $photo_url, $duedate, $type, $group_id) {
        $sql = "INSERT INTO `kb_users` (`email`, `password`, `mother`, `partner`, `photo_url`, `duedate`, `type`, `group_id`) VALUES (:email, :password, :mother, :partner, :photo_url, :duedate, :type, :group_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', Util::encrypt($password));
        $stmt->bindValue(':mother', $mother);
        $stmt->bindValue(':partner', $partner);
        $stmt->bindValue(':photo_url', $photo_url);
        $stmt->bindValue(':duedate', $duedate);
        $stmt->bindValue(':type', $type);
        $stmt->bindValue(':group_id', $group_id);
        if ($stmt->execute()) {
            return $this->selectById($this->pdo->lastInsertId());
        }

        return array();
    }

    public function update($id, $email, $mother, $partner, $photo_url, $duedate, $type, $group_id) {
        $sql = "UPDATE `kb_users` SET `email` = :email, `mother` = :mother, `partner` = :partner, `photo_url` = :photo_url, `duedate` = :duedate, `type` = :type, `group_id` = :group_id WHERE `id` = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':mother', $mother);
        $stmt->bindValue(':partner', $partner);
        $stmt->bindValue(':photo_url', $photo_url);
        $stmt->bindValue(':duedate', $duedate);
        $stmt->bindValue(':type', $type);
        $stmt->bindValue(':group_id', $group_id);
        if ($stmt->execute()) {
            return $this->selectById($id);
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
