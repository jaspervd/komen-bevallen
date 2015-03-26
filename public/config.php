<?php
session_start();
define("WWW_ROOT", dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

require_once WWW_ROOT . 'classes' . DIRECTORY_SEPARATOR . 'Util.php';
require_once WWW_ROOT . 'dao' . DIRECTORY_SEPARATOR . 'UsersDAO.php';
$errors = array();
$usersDAO = new UsersDAO();

if (!empty($_POST['login'])) {
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['login']['email'] = 'Geen geldig e-mailadres ingevuld.';
    }
    if (empty($_POST['password'])) {
        $errors['login']['password'] = 'Je hebt geen wachtwoord ingevuld.';
    }
    if (empty($errors)) {
        $user = $usersDAO->authenticate($_POST['email'], $_POST['password']);
        if (!empty($user)) {
            unset($user['password']);
            $_SESSION['komen_bevallen']['user'] = $user;
        }
        else {
            $errors['login'][] = 'Foute inloggegevens.';
        }
    }
}

if (!empty($_POST['register'])) {
    if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['register']['email'] = 'Geen geldig e-mailadres ingevuld.';
    }
    if (empty($_POST['password'])) {
        $errors['register']['password'] = 'Je hebt geen wachtwoord ingevuld.';
    }
    else {
        if ($_POST['password'] !== $_POST['passwordconfirm']) {
            $errors['register']['passwordconfirm'] = 'De wachtwoorden komen niet overeen.';
        }
    }
    if (empty($errors)) {
        $user = $usersDAO->register($_POST['email'], $_POST['password']);
        if (!empty($user)) {
            unset($user['password']);
            $_SESSION['komen_bevallen']['user'] = $user;
        }
        else {
            $errors['register'][] = 'Er is iets misgegaan tijdens het registreren.';
        }
    }
}
