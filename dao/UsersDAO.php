<?php
require_once __DIR__ . '/DAO.php';
class UsersDAO extends DAO
{
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
        if (!empty($user)) {
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }

        return array();
    }

    public function register($email, $password, $mother, $partner, $photo_url, $duedate, $type) {
        $sql = "INSERT INTO `kb_users` (`email`, `password`, `mother`, `partner`, `photo_url`, `duedate`, `type`) VALUES (:email, :password, :mother, :partner, :photo_url, :duedate, :type)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':password', Util::encrypt($password));
        $stmt->bindValue(':mother', $mother);
        $stmt->bindValue(':partner', $partner);
        $stmt->bindValue(':photo_url', $photo_url);
        $stmt->bindValue(':duedate', $duedate);
        $stmt->bindValue(':type', $type);
        if ($stmt->execute()) {
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
